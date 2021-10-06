# Contao Author Bundle

Show additional author information on a reader page

## Installation

`composer require dreibein/contao-author-bundle`

## Usage
- Create a user
- Add author data to the user (description, image etc.)
- Create a frontend module "author" and set the scope (News, Events, FAQ)
- Insert the module on a reader page (e.g. above a news-reader-module)
- For news entries there is the possibility to show the author within the news-template. For this case you have to provide the image-size for the author image.

## Features
- native Contao image support
- [schema.org](https://schema.org/author) author tags
- author data also added to the news-template-object

### News Template
The author data is added to the new template.
Following properties are available in the template:
- `$this->authorUser` (instance of Contao\UserModel)
- `$this->authorLinks` (array of links)
- `$this->authorImage` (image object)

The image object could be used this way:
```php
$this->insert('picture_default', $this->authorImage->picture);
```

### Back end view
![User](docs/user.png)

### Module configuration
![Module](docs/module-example.png)

### Front end view (example)
![Front end](docs/frontend.png)
