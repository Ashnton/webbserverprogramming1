import csv, random, math, datetime

# Today's date is assumed to be 2025-03-18 (as per current context)
today = datetime.date(2025, 3, 18)
start_date = today - datetime.timedelta(days=999)  # last 1000 days

data = []
for i in range(1000):
    current_date = start_date + datetime.timedelta(days=i)
    # Simulate temperature with a sinusoidal pattern to mimic seasonal variation:
    # Average temperature oscillates roughly between 0 and 20°C.
    day_of_year = current_date.timetuple().tm_yday
    base_temp = 10 + 10 * math.sin(2 * math.pi * day_of_year / 365)
    noise = random.uniform(-3, 3)
    temp = round(base_temp + noise, 1)
    # Append tuple: (index, temperature)
    data.append((i+1, temp))

with open("stockholm_temperature.csv", "w", newline="") as f:
    writer = csv.writer(f)
    writer.writerow(["Index", "Temperatur (°C)"])
    writer.writerows(data)