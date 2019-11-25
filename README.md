#WEB 2
---

Файлы **Autoloaer-ы** регистрируют классы из папок, только те которые обявлены в коде.

Модели такие как **user**, **order_placed** и т.д. выступают в роли мини программ и емеют свой индекс.

Так же могут содержать свою логику работы не зависимую от остальных моделей.

---

**Идеология данного проета, такова:**

Нет обращения на прямую к БД, а есть сервисы(подобие RESTfull) к которым обращаются модели для 
забора данных или отдают данные на обработку. 
Обмен данными между моделями и сервисами происходит в строго структурированном JSON формате.
Таким образом используя такой подход, модели могут обрабатывать данные из лубых источников хранения и обработки данных. 
