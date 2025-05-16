<?php
// buy_bundle.php — Handles bundle purchases by network
$network = isset($_GET['network']) ? htmlspecialchars($_GET['network']) : 'MTN';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buy <?php echo $network; ?> Bundle</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
    .container { max-width: 500px; margin: auto; background: white; padding: 2em; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align: center; }
    label { display: block; margin-top: 1em; }
    input, select { width: 100%; padding: 0.5em; margin-top: 0.5em; }
    button { margin-top: 1.5em; width: 100%; padding: 0.7em; background: #003366; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #002244; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Buy <?php echo $network; ?> Bundle</h2>
    <form action="confirmation_page.php" method="POST">
      <input type="hidden" name="network" value="<?php echo $network; ?>">

      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" placeholder="e.g. 0541234567" required>

      <label for="amount">Amount (GHS)</label>
      <input type="number" id="amount" name="amount" min="1" required>

      <label for="bundle">Bundle Package</label>
      <select name="bundle" id="bundle">
        <option value="small">Small Bundle</option>
        <option value="medium">Medium Bundle</option>
        <option value="large">Large Bundle</option>
      </select>

      <button type="submit">Confirm Purchase</button>
    </form>
  </div>
</body>
</html>
