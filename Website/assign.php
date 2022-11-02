<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Asign People</title>
  </head>
  <body>
    <div class="container">
        <table class="items-table">
          <thead class="table-header">
            <th class="table-header-text">Item Name</th>
            <th class="table-header-text">Price</th>
            <th class="table-header-text">Person</th>
          </thead>

          <tr class="table-row">
            <td class="table-data" id="table-item">Item 1</td>
            <td class="table-data" id="table-price">20.00$</td>
            <td class="table-data" id="table-person">
              <select class="person-selection" name="person-selection" id="person-selection">
                <option class="person-selection-option" value="Person1">Person1</option>
                <option class="person-selection-option" value="Person2">Person2</option>
                <option class="person-selection-option" value="Person3">Person3</option>
              </select>
            </td>
          </tr>

        </table>

        <button type="button" name="Calculate">Calculate</button>
    </div>
  </body>
</html>
