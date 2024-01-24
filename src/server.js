import express from "express";
import bodyParser from "body-parser";
import cors from "cors";

import routes from "./routes/index.js";

const app = express();

app.use(cors());

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));

app.use("/", routes);

const port = 3001;

app.listen(port, () => {
	console.log(`Server started on port ${port}!`);
});
