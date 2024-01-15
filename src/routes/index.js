import express from "express";

const router = express.Router();

// GET endpoint
router.get("/protocolos/:id", (req, res) => {
    const { id } = req.params;

	return res.json({ id });
});

export default router;
