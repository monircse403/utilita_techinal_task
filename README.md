
How to Usage : 

1. Inside the Config file you can set how many data you want to generate. First parameter is no of rows, then start date and endnote which will generate the data accordingly

2. Run php index.php 4.3 2.2 where First argumenet is your php path then index file and last two parameters are peak_hour_rate and off-peak hour rates

3. The expected output will be in json array


The arguments must be float/int

The output will be json format with the data as array


Example:  php index.php 4.2 1.2


Expected Json Output:

[{"meterId":34,"timestamp":"2023-12-01T21:56:57","meter_reading_in_kilowatt_hours":8,"isPeakHourRate":"Peak Hour Rate: 4.2","totalBill":33.6},{"meterId":7,"timestamp":"2023-12-01T09:22:29","meter_reading_in_kilowatt_hours":131,"isPeakHourRate":"Peak Hour Rate: 4.2","totalBill":550.2},{"meterId":2,"timestamp":"2023-12-01T16:47:44","meter_reading_in_kilowatt_hours":163,"isPeakHourRate":"Peak Hour Rate: 4.2","totalBill":684.6},{"meterId":41,"timestamp":"2023-12-01T10:05:34","meter_reading_in_kilowatt_hours":50,"isPeakHourRate":"Peak Hour Rate: 4.2","totalBill":210},{"meterId":37,"timestamp":"2023-12-01T23:57:38","meter_reading_in_kilowatt_hours":101,"isPeakHourRate":"Peak Hour Rate: 4.2","totalBill":424.2}]