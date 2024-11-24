import type { Express } from "express";
import { db } from "../db";
import { campaigns, donations } from "@db/schema";
import { desc } from "drizzle-orm";
import { sendDonationConfirmation } from "./services/email";
import { processGofundmePayment } from "./services/gofundme";

export function registerRoutes(app: Express) {
  app.get("/api/campaigns", async (req, res) => {
    try {
      const results = await db.select().from(campaigns).orderBy(desc(campaigns.createdAt));
      res.json(results);
    } catch (error) {
      res.status(500).json({ error: "Failed to fetch campaigns" });
    }
  });

  app.post("/api/donations", async (req, res) => {
    try {
      const donation = req.body;
      
      // Process payment through GoFundMe
      await processGofundmePayment(donation);
      
      // Save donation record
      const [result] = await db.insert(donations).values(donation).returning();
      
      // Send confirmation email
      await sendDonationConfirmation(donation.email, result);
      
      res.json(result);
    } catch (error) {
      res.status(500).json({ error: "Failed to process donation" });
    }
  });
}
