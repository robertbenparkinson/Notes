# Paragraph Notes
Paragraphs are great but they are a big of a pain when it comes to extracting the data out of them.

```php

public functions test_page() {

    $nid = 1;
    $node = Node::load($nid);

    $title = $node->get('title')->value;
    $body = $node->get('body')->value;

```
 The Code below will select all of the paragraphs associated with the ```field_test_paragraph``` field attached to a node.

From there it will select the ```field_paragraph_name``` and its associated value and assign it to the ```$build``` array under ```$build['#para'][$i]['#markup]```. 



```php


    $paragraphs = $node->field_test_paragraph->getValue();

    $i = 0;

    foreach ($paragraphs as $paragraph){

        $p = Paragraph::load((int)$paragraph['target_id']);

        // Staff Name
        $build['#para'][$i]['name']['#type'] = 'markup';
        $build['#para'][$i]['name']['#markup'] = $p->field_paragraph_name->value;
        
        // For whatever reason sometimes Drupal doesn't like the code above, if so try one of the two below.
        // $build['#para'][$i]['name']['#markup'] = $p->field_paragraph_name->->get(0)->value;
        // $build['#para'][$i]['name']['#markup'] = $p->get('field_paragraph_name')->value;
        
        
        $i = $i +1;
    }


    $build['#theme'] = 'test_page';
    $build['#title'] = $title;
    $build['#body']['#type'] = 'markup';
    $build['#body']['#markup'] = $body;

    return $build;

}

```
You will need to make sure that the ```para``` variable is add to the hook module for the ```test_page``` hook.

```php
function test_theme() {
  return [
    'test_page' => [
        'variables' => [
            'title' => NULL,
            'body' => NULL,
            'para' => NULL,
        ],
    ],
  ];
}

```
Now on the ```test-page.html.twig``` page the ```{{ para }}``` variable will be available.



```TWIG
{# test-page.html.twig #}


{% for p in para %}
    <h1>{{ p.name}}</h1>
{% endfor %}




```




