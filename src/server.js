import express from "express";
import bodyParser from "body-parser";

import routes from "./routes/index.js";
import { authenticate } from "./database/connection.js";

const app = express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

app.use("/", routes);

// Verify singleton connection
await authenticate()
	.then(() => {
		console.log("Database connection successful");
		// Start the server
		const port = 3000;
		app.listen(port, () => {
			console.log(`Server started on port ${port}`);
		});
	})
	.catch((error) => {
		console.error("Unable to connect to the database:", error);
	});
