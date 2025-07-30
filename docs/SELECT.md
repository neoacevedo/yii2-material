# Select

`Select` renderiza el componente web [Select](https://material-web.dev/components/select/) de Material Web.

 Ejemplo de uso:
 
  ```php
  <?php
  echo Select::widget([
   'name' => 'country',
   'selection' => 'US',
   'items' => [
       'US' => 'United States',
       'CA' => 'Canada',
       'MX' => 'Mexico',
   ],
   'options' => [
       'prompt' => 'Select a country...',
       'variant' => Select::TYPE_FILLED,
       'options' => [
           'US' => ['data-code' => 'USA'],
           'CA' => ['disabled' => true],
       ],
   ],
  ]);
  ```
  
  Con la clase auxiliar `\neoacevedo\yii2\material\Html`:
  
  ```php
  <?php
  echo Html::dropdownList('country', 'US', [
       'US' => 'United States',
       'CA' => 'Canada',
       'MX' => 'Mexico', 
  ], [
       'prompt' => 'Select a country...',
       'variant' => Select::TYPE_FILLED,
       'options' => [
           'US' => ['data-code' => 'USA'],
           'CA' => ['disabled' => true],
       ],
  ]);
  ```
  
  En HTML se puede usar de la siguiente manera:
  
  ```html
  <md-outlined-select>
      <md-select-option aria-label="blank"></md-select-option>
      <md-select-option selected value="apple">
          <div slot="headline">Apple</div>
      </md-select-option>
      <md-select-option value="apricot">
          <div slot="headline">Apricot</div>
      </md-select-option>
  </md-outlined-select>
 
  <md-filled-select>
      <md-select-option aria-label="blank"></md-select-option>
      <md-select-option value="apple">
          <div slot="headline">Apple</div>
      </md-select-option>
      <md-select-option value="apricot">
          <div slot="headline">Apricot</div>
      </md-select-option>
  </md-filled-select>
  ```