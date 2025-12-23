# CI4 MCP Server

This is a Model Context Protocol (MCP) server designed to help AI agents interact with this CodeIgniter 4 project.

## Features

- **list_routes**: View all application routes.
- **list_controllers / list_models**: See the project structure.
- **run_spark**: Execute any `php spark` command.
- **get_env**: Access environment configuration.
- **get_project_summary**: Quick stats about controllers, models, and views.

## Installation

1. Ensure Node.js is installed.
2. Navigate to the `mcp` directory.
3. Run `npm install`.

## Configuration for Cline / Claude Desktop

Add the following to your `mcp_config.json`:

```json
{
  "mcpServers": {
    "ci4-project": {
      "command": "node",
      "args": ["c:/laragon2/www/zaky/new-admin/mcp/index.js"],
      "cwd": "c:/laragon2/www/zaky/new-admin/mcp"
    }
  }
}
```

## Running

The server uses Standard Input/Output (stdio) to communicate. It is intended to be started by an MCP client.
