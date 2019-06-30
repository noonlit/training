# https://www.hackerrank.com/challenges/japanese-cities-attributes/problem
select * from city where countrycode = 'jpn';

# https://www.hackerrank.com/challenges/japanese-cities-name/problem
select name from city where countrycode = 'jpn';

# https://www.hackerrank.com/challenges/weather-observation-station-1/problem
select city, state from station;

# https://www.hackerrank.com/challenges/weather-observation-station-3/problem
select distinct city from station where (id % 2 = 0);

# https://www.hackerrank.com/challenges/weather-observation-station-4/problem
select count(city) - count(distinct city) from station;

# https://www.hackerrank.com/challenges/weather-observation-station-5/problem
(select city, length(city) as city_length from station order by city_length, city limit 1) 
union 
(select city, length(city) as city_length from station order by city_length desc, city limit 1)

# https://www.hackerrank.com/challenges/weather-observation-station-6/problem
select city from station where substr(city, 1, 1) in ('a', 'e', 'i', 'o', 'u');

# https://www.hackerrank.com/challenges/weather-observation-station-7/problem
select distinct city from station where substr(city, -1) in ('a', 'e', 'i', 'o', 'u');

# https://www.hackerrank.com/challenges/weather-observation-station-8/problem
select city from station where (substr(city, 1, 1) in ('a', 'e', 'i', 'o', 'u') AND substr(city, -1) in ('a', 'e', 'i', 'o', 'u'));

# https://www.hackerrank.com/challenges/weather-observation-station-9/problem
select distinct city from station where substr(city, 1, 1) not in ('a', 'e', 'i', 'o', 'u');

# https://www.hackerrank.com/challenges/weather-observation-station-10/problem
select distinct city from station where substr(city, -1) not in ('a', 'e', 'i', 'o', 'u');

# https://www.hackerrank.com/challenges/weather-observation-station-11/problem
select distinct city from station where (substr(city, 1, 1) not in ('a', 'e', 'i', 'o', 'u') or substr(city, -1) not in ('a', 'e', 'i', 'o', 'u'));

# https://www.hackerrank.com/challenges/weather-observation-station-12/problem
select distinct city from station where (substr(city, 1, 1) not in ('a', 'e', 'i', 'o', 'u') and substr(city, -1) not in ('a', 'e', 'i', 'o', 'u'));

# https://www.hackerrank.com/challenges/more-than-75-marks/problem
select name from students where marks > 75 order by substring(name, -3) asc, id asc;

# https://www.hackerrank.com/challenges/name-of-employees/problem
select name from employee order by name;

# https://www.hackerrank.com/challenges/salary-of-employees/problem
select name from employee where salary > 2000 and months < 10 order by employee_id;

# https://www.hackerrank.com/challenges/what-type-of-triangle/problem
select
  case
    when a = b and b = c then "Equilateral"
    when ((a + b <= c) or (a + c <= b) or (b + c <= a)) then "Not A Triangle"
    when ((a = b and a != c) or (a = c and a != b) or (b = c and a != b)) then "Isosceles"
    else "Scalene"
  end
from triangles;

# https://www.hackerrank.com/challenges/revising-aggregations-the-count-function/problem
select count(*) from city where population > 100000;

# https://www.hackerrank.com/challenges/revising-aggregations-sum/problem
select sum(population) from city where district = 'California';

# https://www.hackerrank.com/challenges/revising-aggregations-the-average-function/problem
select avg(population) from city where district = 'California';

# https://www.hackerrank.com/challenges/average-population/problem
select floor(avg(population)) from city;

# https://www.hackerrank.com/challenges/japan-population/problem
select sum(population) from city where countrycode = 'JPN';

# https://www.hackerrank.com/challenges/population-density-difference/problem
select max(population) - min(population) from city;

# https://www.hackerrank.com/challenges/the-blunder/problem
select ceil(avg(Salary) - avg(replace(Salary,'0',''))) from employees;

# https://www.hackerrank.com/challenges/earnings-of-employees/problem
select months * salary as earnings, count(*) from employee group by earnings desc limit 1;
