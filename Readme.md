###### Input
`<x-form::input type="text" name="test" value="test" placeholder="test"/>`
###### Select
   `@php($array = [
    'test',
    'test2',
    'test3',
    ])`

    `<x-form::select name="test" labelName="select" selected="1" :data="$array"/>`
###### Textarea
`<x-form::textarea name="test" labelName="textarea" value="123" placeholder="test"/>`
