import { pgTable, varchar, serial, timestamp, decimal, integer } from "drizzle-orm/pg-core";
import { createInsertSchema, createSelectSchema } from "drizzle-zod";
import { z } from "zod";

export const campaigns = pgTable("campaigns", {
  id: serial("id").primaryKey(),
  title: varchar("title", { length: 255 }).notNull(),
  description: varchar("description", { length: 1000 }).notNull(),
  imageUrl: varchar("image_url", { length: 255 }).notNull(),
  goal: decimal("goal", { precision: 10, scale: 2 }).notNull(),
  current: decimal("current", { precision: 10, scale: 2 }).notNull(),
  gofundmeUrl: varchar("gofundme_url", { length: 255 }).notNull(),
  createdAt: timestamp("created_at").defaultNow(),
  updatedAt: timestamp("updated_at").defaultNow(),
});

export const donations = pgTable("donations", {
  id: serial("id").primaryKey(),
  email: varchar("email", { length: 255 }).notNull(),
  amount: decimal("amount", { precision: 10, scale: 2 }).notNull(),
  recurring: integer("recurring").default(0),
  campaignIds: varchar("campaign_ids", { length: 255 }).notNull(),
  createdAt: timestamp("created_at").defaultNow(),
});

export const insertCampaignSchema = createInsertSchema(campaigns);
export const selectCampaignSchema = createSelectSchema(campaigns);
export type InsertCampaign = z.infer<typeof insertCampaignSchema>;
export type Campaign = z.infer<typeof selectCampaignSchema>;

export const insertDonationSchema = createInsertSchema(donations);
export const selectDonationSchema = createSelectSchema(donations);
export type InsertDonation = z.infer<typeof insertDonationSchema>;
export type Donation = z.infer<typeof selectDonationSchema>;
