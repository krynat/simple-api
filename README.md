# Simple API

This project is a simple API that allows users to store and retrieve messages. It provides endpoints for creating new messages, listing all messages, and retrieving a specific message by its UUID.

## Features:

- Create Message: Users can send a POST request to the /message endpoint with a JSON payload containing the content of the message. The API will store the message and return a UUID representing the created message.
- List Messages: The /messages endpoint returns a JSON response containing a list of all stored messages. Users can sort the messages by creation time or UUID.
- Get Message: Users can retrieve a specific message by sending a GET request to the /message/{uuid} endpoint, where {uuid} is the UUID of the message. The API will return the message in JSON format.

## Usage:

1. Clone the repository from GitHub.
2. Install Docker and Docker Compose if not already installed.
3. Run docker-compose up -d to start the development environment.
4. Access the API endpoints at the specified URLs (e.g., http://localhost/api/messages for listing messages).