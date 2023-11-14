<?php
/**
 * JsonDocument
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace App\Http\Schemas;


class JsonDocument
{
    const JSON_DOCUMENTS_SCHEMA = <<<'JSON'
{
    "type": "object",
    "properties": {
        "id": {
            "type": "integer"
        },
        "name": {
            "type": "string"
        },
        "data": {
            "type": "array",
            "items": {
                "$ref": "#/definitions/document"
            }
        }
    },
    "required":["data", "return-url"],
    "definitions": {
        "document": {
            "type": "object",
            "properties": {
                "wallet": {
                    "type": "string"
                },
                "link": {
                    "type": "string"
                }
            },
            "required":["id", "wallet", "link"]
        }
    }
}
JSON;
}
