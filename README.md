# Photo Registry Service

## Usage

All responses will have the form

```json
{
    "data": "Mixed type holding the content of the response",
    "message": "Description of what happened"
}
```

Subsequent response definitions will only detail the expected value of the `data field`

### List of all photos

**Definition**

`GET /photos`

**Response**
- `200 OK` on success

```json
    [
        {
            "identifier" : "4432343",
            "file_name" : "Josh_Portrait.jpg",
            "date_modified": "2020-03-06 1:33 PM",
            "size" : "12KB",
            "descriptor" : "person"
        },
        {
            "identifier" : "5552213",
            "file_name" : "dog.jpg",
            "date_modified": "2020-01-17 10:14 AM",
            "size" : "2000KB",
            "descriptor" : "dog"
        }
    ]
```

### Registering a new photo

**Definition**

`POST /photos`

**Arguments**

- `"identifier":integer` a globally unique identifier for this photo
- `"file_name":string` a friendly name for this file
- `"date_modified":string` the date the file was last modified
- `"size":string` the size of the photo in KB
- `"descriptor":string` a word one description describing the contents of the photo

**Response**

- `201 Created` on success

```json
{
    "identifier" : "4432343",
    "file_name" : "Josh_Portrait.jpg",
    "date_modified": "2020-03-06 1:33 PM",
    "size" : "12KB",
    "descriptor" : "person"
}
```

## Lookup photo details

`GET /photos/<identifier>`

**Response**

- `404 Not Found` if the photo does not exist
- `200 OK` on success

```json
{
    "identifier" : "4432343",
    "file_name" : "Josh_Portrait.jpg",
    "date_modified": "2020-03-06 1:33 PM",
    "size" : "12KB",
    "descriptor" : "person"
}
```

## Delete a photo

**Definition**

`DELETE /photos/<identifier>`

**Response**

- `404 Not Found` if the photo does not exist
- `204 No Content` on success

