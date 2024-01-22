import { query } from "../database/db.js";
import Response from "../models/response.js";
import { getDataCertidao, getStatusCertidao } from "./get-certidao-data.js";

const VIEW_NAME = "VW_PROTOCOLO_STATUS_NEW";

export default async function getDocumentTypeData(codSenha) {
	let response;

	const documentTypeData = await query(
		`SELECT tipo FROM ${VIEW_NAME} WHERE cod_senha = '${codSenha}'`,
	);

	response = new Response(documentTypeData[0].tipo);

	if (documentTypeData[0].tipo.includes("CERTIDAO")) {
		const certidaoData = await getDataCertidao(
			documentTypeData[0].tipo,
			codSenha,
		);
		response.setCertidao(certidaoData);

		const status = await getStatusCertidao(
			certidaoData.codCertRi,
			certidaoData.datProtoRi,
		);

		response.setStatus(status);
	} else {
		// The documentTypeData.tipo does not contain the string "CERTIDAO"
		console.log("Document type is not CERTIDAO");
	}

	return response;
}
