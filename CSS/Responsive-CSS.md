# How to Build a Responsive CSS Layout for Both Large and Small Devices 


## HTML 
Add the '@media only screen and (min-width: 400px)' meta tag to head of your html file   

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```
## CSS
The initial background-color is set to red.
For @media screens with a width smaller than 400px the background-color will turn blue. 
```css
body {
    background-color: red;
}

@media only screen and (min-width: 400px) {
    body { 
       background-color: blue; 
    }
} 
```

## Full Example
```html
<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: red; 
        }
        
        /* For width 400px and larger: */
        /* When the screen is less than 400px it will change the background color to green */
        @media only screen and (min-width: 400px) {
            body { 
               background-color: blue; 
            }
        }
    </style>
</head>
<body>

    <p>Resize the browser width and the background color will change at 400px.</p>

</body>
</html>
```
