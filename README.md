Smart meters send electricity usage data in the following format: (meter_id,
timestamp, meter reading in kilowatt-hours). The data is transmitted periodically
throughout the day. (e.g. [1, '2023-10-10T08:00:00', 150])
Electricity usage is billed based on different rates at different times of the day (peak
and off-peak). These rates are provided as input to the system.
Implement a billing algorithm that calculates the total cost incurred by each
household based on their electricity usage and the corresponding rates.
Consider peak hours (e.g., 7 AM to midnight) as high-rate periods, off-peak hours
(e.g.,midnight to 7am) as low-rate periods

Assumptions:
All meters are new, without prior usage.
Meters will send data hourly
Meters won't sent missing or corrupted data


Usage : 

1. First command is your php path then index file and last two parameters are peak_hour_rate and off-peak hour rates
2. The expected output will be in json array

php index.php 4.3 2.2