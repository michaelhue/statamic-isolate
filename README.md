# isolate

_isolate_ is a plugin for [Statamic](http://statamic.com) which isolates the page's content from all contextual data. Because sometimes you need a little space.

## Installing

1. Download the zip file (or clone via git) and unzip it or clone the repo into /_add-ons/.
2. Ensure the folder name is `isolate` (Github timestamps the download folder).
3. Enjoy.

## Usage

Just wrap the content in which you want to access only the page's data in `{{ isolate }}` tags.

```
{{ isolate }}
  <h1>{{ title }}</h1>
  {{ content }}
{{ /isolate }}
```

If you want to pull in one or more context variables, use the `except` parameter.

```
{{ isolate except="_site_url|environment"}}
  <h1>{{ title }}</h1>

  Home: {{ _site_url }}
  Environment: {{ environment }}
{{ /isolate }}
```

## Why?

Sometimes Statamic mixes up content data with context data. For example, when looping through entries with an optional custom field (let's say `subtitle`), an entry that doesn't provide data for this field will inherit the value of the last entry that did provide a value for the field.

| First entry     | Second Entry  | Template                 | Result   |
| :-------------- | :------------ | :----------------------- | :------- |
| ---             | ---           | {{ entries:listing }}    | First    |
| title: First    | title: Second |   {{ title }}            | Hello    |
| subtitle: Hello | ---           |   {{ subtitle }}         |          |
| ---             |               | {{ /entries:listing }}   | Second   |
|                 |               |                          | Hello    |

You would expect the subtitle of the second entry to be empty but since Statamic doesn't save empty values in the content files, the subtitle (which is now part of the context) will carry over from the first entry. In order to prevent that, you can use `isolate`.

```
{{ entries:listing }}
  {{ isolate }}
	{{ title }}
	{{ subtitle }}
  {{ /isolate }}
{{ /entries:listing }}
```

Boom, no more subtitle for the second entry. There are other, more complex situations in which it's useful to isolate the page content from all context data.