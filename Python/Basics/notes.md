# Python Notes

## For Loop
```python
for i in range(0,1):
    print(i)
```

## Functions

```python
def my_function(name):
    print("Hi " + name)

```

## Random Numbers

### Random Number
```python
import random

random.randint(1,100) 
```
> 95

### Shuffle a list
```python
import random

x = [1,2,3,4,5,6,7,8,9,10]
random.shuffle(x)
```
> [2, 1, 3, 6, 9, 8, 7, 4, 5, 10]


### How to Time Functions

```python
import time

start = time.time()

my_function_to_check()

end = time.time()

print('Time to run function: ', end - start)

```