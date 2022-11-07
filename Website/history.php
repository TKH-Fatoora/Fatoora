<?php
include 'Templates/navbar.php';
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/history_styles.css">
    <title>History</title>
  </head>
  <body>
    <section class="results">
      <h1>History</h1>
      <div class="container">
        <div class="box">
          <div class="name">
            <h2>07-11-2022</h2>
          </div>
          <table class="table">
            <thead class="tabletitle">
              <th>Expense Title</th>
              <th>Category</th>
              <th>Method</th>
              <th>Price</th>
            </thead>

            <tr class="rowitem">
              <td class="itemtext">Communication</td>
              <td class="itemtext">food</td>
              <td class="itemtext">cash</td>
              <td class="itemtext">$375.00</td>
            </tr>

            <tr class="rowitem">
              <td class="itemtext">Asset Gathering</td>
              <td class="itemtext">coffee</td>
              <td class="itemtext">credit</td>
              <td class="itemtext">$225.00</td>
            </tr>

            <tr class="rowitem">
              <td class="itemtext">Design Development</td>
              <td class="itemtext">transportation</td>
              <td class="itemtext">$debit</td>
              <td class="itemtext">$375.00</td>
            </tr>

            <tr class="rowitem">
              <td class="itemtext">Animation</td>
              <td class="itemtext">others</td>
              <td class="itemtext">pre-paid</td>
              <td class="itemtext">$1500.00</td>
            </tr>

            <tr class="rowitem">
              <td class="itemtext">Animation Revisions</td>
              <td class="itemtext">food</td>
              <td class="itemtext">cash</td>
              <td class="itemtext">$750.00</td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td><h3>Total</h3></td>
              <td><h3>$3,644.25</h3></td>
            </tr>
          </table>
        </div>
      </div>
    </section>
  </body>
</html>

 <?php
include 'Templates/footer.php';
  ?>
