import express from "express";
import getDocumentTypeData from "../services/get-document-data.js";

const router = express.Router();

// GET endpoint
router.get("/protocolos/:id", async (req, res) => {
	const { id } = req.params;

	return getDocumentTypeData(id)
		.then((data) => {
			res.status(200).json(data);
		})
		.catch((err) => {
			console.log(err);
			res.status(500).json({ message: err });
		});
});

export default router;
