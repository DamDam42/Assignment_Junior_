<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Rate Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4>Electricity Rate Calculator</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Voltage (V):</label>
                        <input type="number" class="form-control" name="voltage" required>
                    </div>
                    <div class="form-group">
                        <label>Current (A):</label>
                        <input type="number" class="form-control" name="current" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Rate (cents per kWh):</label>
                        <input type="number" class="form-control" name="rate" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-success">Calculate</button>
                </form>

                <?php
                function calculatePower($voltage, $current) {
                    return ($voltage * $current) / 1000; 
                }

                function calculateCharge($energy, $rate) {
                    return $energy * ($rate / 100);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $voltage = $_POST['voltage'];
                    $current = $_POST['current'];
                    $rate = $_POST['rate'];

                    $power = calculatePower($voltage, $current);
                    $rate_in_rm = $rate / 100;
                ?>
                <div class="mt-4 p-3 bg-white border rounded">
                    <h5>Results:</h5>
                    <p><strong>Power:</strong> <?php echo number_format($power, 5); ?> kW</p>
                    <p><strong>Rate:</strong> RM <?php echo number_format($rate_in_rm, 3); ?></p>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th># Hour</th>
                                <th>Energy (kWh)</th>
                                <th>Total (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($hour = 1; $hour <= 24; $hour++): 
                                $energy = $power * $hour;
                                $total = calculateCharge($energy, $rate);
                            ?>
                            <tr>
                                <td><?php echo $hour; ?></td>
                                <td><?php echo number_format($energy, 5); ?></td>
                                <td><?php echo number_format($total, 2); ?></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>