import { defineConfig } from "drizzle-kit";

// Database configuration from environment variables

export default defineConfig({
  out: "./migrations",
  schema: "./db/schema.ts",
  dialect: "postgresql",
  dbCredentials: {
    connectionString: process.env.DATABASE_URL,
  },
});
