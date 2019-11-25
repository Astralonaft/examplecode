<?php


class Html
{
	/*
	 * 		TODO этот метод вормирует аттрибуты таблицы
	 * */
	public function tableParams(array $params = [], $to_str = false)
	{
		$filterResult = [];

		$default =  [
			'data-url' => "false"                       		// "json/data1.json"
			,'data-cache'  => "false"
			,'data-toggle' => "table"
			,'date-locale' => "ru-RU"
			,'data-card-view' => "false"                		//  Блочный вид если нужен при загрузке то TRUE
			,'data-sort-stable' => "true"               		//  сортировка в колонках
			,'data-click-to-select' => "false"          		//  Отобразить checkbox для выделения строк
			// кнопки
			,'data-show-refresh' => "false"             		//  кнопка обновить
			,'data-show-columns' => "true"              		//  кнопка отображает механизм скрытия колонок
			,'data-show-fullscreen' => "false"
			,'data-show-toggle' => "false"               		//  Переулючатель (кнопка) Блочный вид / Табличный вид
			,'data-buttons' => "btn btn-sm"
			,'data-buttons-class' => "light"
			// AJAX - ппередаются параметрах
			,'data-method' => "false"
			,'data-ajax' => "false"                         	// Имя функции запроса к серверу //,'data-ajax' => "getDataAjaxToTable"
			,'data-response-handler' => "false"             	// Имя функции обработки ответа
			,'data-content-type' => "application/x-www-form-urlencoded"
			// Пагинация
			,'data-pagination' => "true"                        //  пагинация
			,'data-pagination-pre-text' => "Назад"              //  кнопка пагинации
			,'data-pagination-next-text' => "Вперёд"            //  кнопка пагинации
			,'data-page-size' => "50"                           //  кол-во строк отображения
			,'data-side-pagination' => "false"                 	//  server / client
			,'data-page-list' => "[10, 25, 50, 100, 200, All]"
			,'data-search' => "true"                            //  поиск по таблице
			,'data-search-text' => "false"                      // "Значение по умолчанию"
			// Detail View
			,'data-detail-view'=>"false"                        //  Показывает детали строки тблицы если она длинная
			,'data-detail-formatter'=>"false"                   //  Имя функции обработки показа деталей строки
			// row attr
			,'data-row-attributes' => "false"       			// Имя функции (js) с атрибутами для строки
			// Export
			,'data-show-export' => "false"
			//,'data-total-field' => "count"              		//  ?
			//,'data-data-field' => "items"               		//  ?
			//,'data-maintain-selected' => "false"
			,'data-icons-prefix' => "false"
			,'data-icons' => "false"
			,'data-show-footer' => "false"
			//,'data-footer-style' => "false"      				//  Имя стиля для подвала
		];

		if (!empty($params))
		{
			$filterResult = array_filter(array_replace_recursive($default, $params), function ($var) {
				return (strpos($var, 'false') === false);
			});
		}

		if ($to_str)
		{
			return self::tableAttributesToStr($filterResult);
		}

		return $filterResult;

	}
	/*
	 * 		Переводим аттрибуты для тега таблицы в строку
	 * */
	private static function tableAttributesToStr($tableParams)
	{
		$tParams = "";
		foreach($tableParams AS $attr => $params)
		{
			$tParams .= $attr . '="' . $params . '" ';
		}
		return $tParams;
	}

	public function tableBuildTH($columns, $column_action = false)
	{
		$TH = '';
		foreach($columns As $val)
		{
			$code = $val['code'];
			$name = $val['name'];
			$show = $val['show'];

			$TH .= '<th 
						style="" 
						data-field="' . $code . '" 
						data-sortable="true" 
						data-visible="' . $show . '">' . $name . '</th>';
		}

		if ($column_action)
		{
			$TH .= '<th 
					style="" 
					data-field="action" 
					data-sortable="true" 
					data-visible="show">Действия</th>';
		}

		return $TH;
	}

	public function actionButton($model, $id, array $permissions, $model_name = "", $buttons_params = [])
	{
		#	Кнопка открывает просмотр модели
		$show 	= !empty($permissions['show'])
			? '<a 
					class="mr-2 text-info" 
					data-toggle="modal" 
					data-target="#ViewModal" 
					href="#" 
				>
					<i class="mdi icon-sm mdi-eye" data-toggle="tooltip" data-placement="top" data-original-title="Смотреть" model_id = "' . $id . '" ></i>
				</a>'
			: '';
		#	Кнопка открывает форму для редактирования модели
		$edit 	= !empty($permissions['edit'])
			? '<a 
					class = "mr-2 ml-2 text-info" 
					data-toggle = "modal" 
					data-target = "#EditModal"
					href = "#"
				>
					<i class="mdi icon-sm mdi-lead-pencil" data-toggle="tooltip" data-placement="top" data-original-title="Редактировать" model_id = "' . $id . '" ></i>
				</a>'
			: '';
		#	Кнопка удалит мдель
		$delete = !empty($permissions['destroy'])
			?
			'<form id="' . $model . $id . '_destroy" method="POST" action="/new/user?id=' . $id . '">
                        <input name="_method" type="hidden" value="DELETE" autocomplete="off">
                        <input name="_token" type="hidden" value="" autocomplete="off">
                    </form>
                    <button 
                        style="border: 0;background: 0px;cursor: pointer;" 
                        type="button" 
                        class="text-danger" 
                        data-toggle="modal" 
                        data-target="#ConfirmModal"
                        data-model="' . $model . $id . '"
                        data-modelname="' . $model_name . '"
                    >
                        <i class="mdi icon-sm mdi-close-circle" data-toggle="tooltip" data-placement="top" title="Удалить"></i>
                    </button>'
			: '';
		#	Блок кнопок
		$action_button = '<div class="col">
                            <div class="wrapper d-flex justify-content-between">
                                <div class="side-left">
                                    ' . $show . '
                                </div>    
                                <div class="side-left">
                                    ' . $edit .'
                                </div>
                                <div class="side-left">
                                    ' . $delete . '
                                </div>
                            </div>
                          </div>';

		return $action_button;
	}
}