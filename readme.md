## RKeeper 7 CRM API Wrapper

### Установка
```bash
composer require nutnet/rkeeper7-crm-api
```

### Использование
См. [примеры](examples/basic.php)

### Методы
Реализованы (см. [здесь](src/Requests)):
 * Get Cards Info (получить информацию по карте)
 * Transaction (выполнить транзакцию)
 * Get Transactions Info (список транзакций)
 
Для добавления нового метода реализуйте интерфейс `ApiRequest`.
При использовании метода `RequestAbstract::arrayAsXml` возможны след. форматы входных данных:
1. `ключ => значение`, преобразуется в `<ключ>значение</ключ>`
1. ```php
   'ключ' => [
       'value' => 'значение', // необязательно
       'attr' => ['name' => 'test'], // необязательно, аттрибуты элементы
       'children' => [...] // необязательно, дочерние элементы в таком же формате
   ]
преобразуется в `<ключ name="test"">...дочерние элементы...</ключ>`
1. ```php
   'ключ' => [
       [
           'value' => 1
       ],
       [
           'value' => 2,
           'attr' => [
               'test' => 'yes'
           ]
       ]
   ]
преобразуется в:
```xml
<ключ>1</ключ>
<ключ test="yes">2</ключ>
```