import { Server } from "@modelcontextprotocol/sdk/server/index.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import {
  CallToolRequestSchema,
  ListToolsRequestSchema,
} from "@modelcontextprotocol/sdk/types.js";
import { exec } from "child_process";
import { promisify } from "util";
import fs from "fs/promises";
import path from "path";
import { fileURLToPath } from 'url';

const execAsync = promisify(exec);
const __dirname = path.dirname(fileURLToPath(import.meta.url));
const PROJECT_ROOT = path.resolve(__dirname, "..");

const server = new Server(
  {
    name: "ci4-mcp-server",
    version: "1.0.0",
  },
  {
    capabilities: {
      tools: {},
    },
  }
);

/**
 * Helper to run spark commands
 */
async function runSpark(command) {
  try {
    const { stdout, stderr } = await execAsync(`php spark ${command}`, {
      cwd: PROJECT_ROOT,
    });
    return stdout + (stderr ? "\nErrors:\n" + stderr : "");
  } catch (error) {
    return `Error: ${error.message}\nOutput: ${error.stdout}\nStderr: ${error.stderr}`;
  }
}

/**
 * List tools
 */
server.setRequestHandler(ListToolsRequestSchema, async () => {
  return {
    tools: [
      {
        name: "list_routes",
        description: "List all registered routes in the CodeIgniter 4 application",
        inputSchema: { type: "object", properties: {} },
      },
      {
        name: "list_controllers",
        description: "List all controller files in the app/Controllers directory",
        inputSchema: { type: "object", properties: {} },
      },
      {
        name: "list_models",
        description: "List all model files in the app/Models directory",
        inputSchema: { type: "object", properties: {} },
      },
      {
        name: "run_spark",
        description: "Run any CodeIgniter 4 spark command",
        inputSchema: {
          type: "object",
          properties: {
            command: {
              type: "string",
              description: "The spark command to run (e.g., 'make:controller Test')",
            },
          },
          required: ["command"],
        },
      },
      {
        name: "get_env",
        description: "Read the .env file content (database config, app settings)",
        inputSchema: { type: "object", properties: {} },
      },
      {
        name: "get_project_summary",
        description: "Get a summary of the project structure and key statistics",
        inputSchema: { type: "object", properties: {} },
      },
    ],
  };
});

/**
 * Handle tool calls
 */
server.setRequestHandler(CallToolRequestSchema, async (request) => {
  const { name, arguments: args } = request.params;

  try {
    switch (name) {
      case "list_routes": {
        const output = await runSpark("routes");
        return { content: [{ type: "text", text: output }] };
      }

      case "list_controllers": {
        const controllersDir = path.join(PROJECT_ROOT, "app", "Controllers");
        const files = await fs.readdir(controllersDir, { recursive: true });
        return { content: [{ type: "text", text: files.filter(f => f.endsWith('.php')).join("\n") }] };
      }

      case "list_models": {
        const modelsDir = path.join(PROJECT_ROOT, "app", "Models");
        const files = await fs.readdir(modelsDir, { recursive: true });
        return { content: [{ type: "text", text: files.filter(f => f.endsWith('.php')).join("\n") }] };
      }

      case "run_spark": {
        const output = await runSpark(args.command);
        return { content: [{ type: "text", text: output }] };
      }

      case "get_env": {
        const envPath = path.join(PROJECT_ROOT, ".env");
        const content = await fs.readFile(envPath, "utf-8");
        return { content: [{ type: "text", text: content }] };
      }

      case "get_project_summary": {
        const stats = {
          controllers: (await fs.readdir(path.join(PROJECT_ROOT, "app", "Controllers"))).length,
          models: (await fs.readdir(path.join(PROJECT_ROOT, "app", "Models"))).length,
          views: (await fs.readdir(path.join(PROJECT_ROOT, "app", "Views"), { recursive: true })).length,
          migrations: (await fs.readdir(path.join(PROJECT_ROOT, "app", "Database", "Migrations"))).length,
        };
        return { content: [{ type: "text", text: JSON.stringify(stats, null, 2) }] };
      }

      default:
        throw new Error(`Unknown tool: ${name}`);
    }
  } catch (error) {
    return {
      content: [{ type: "text", text: `Error: ${error.message}` }],
      isError: true,
    };
  }
});

/**
 * Start the server
 */
async function main() {
  const transport = new StdioServerTransport();
  await server.connect(transport);
  console.error("CI4 MCP Server running on stdio");
}

main().catch((error) => {
  console.error("Fatal error in main():", error);
  process.exit(1);
});
