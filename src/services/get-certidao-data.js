import Certidao from "../models/certidao.js";
import { query } from "../database/db.js";
import { formatterCurrency } from "../utils/formatter-currency.js";
import { formatDateBR } from "../utils/formatter-date.js";

async function getDataCertidao(certidaoTipo, codSenha) {
	const certidaoData = new Certidao();

	switch (certidaoTipo) {
		case "CERTIDAO DE RI":
			const queryCertidao = `SELECT * FROM certidao_ri WHERE num_proto = '${codSenha}' or num_senha = '${codSenha}'`;

			const result = await query(queryCertidao);

			certidaoData.setCodSenha(result[0].num_senha);
			certidaoData.setCodCertRi(result[0].cod_cert_ri);
			certidaoData.setNumProtoRi(result[0].num_proto);
			certidaoData.setDatProtoRi(result[0].dat_proto);
			certidaoData.setDataUltimaAtualizacao(result[0].data_atualizacao);
			certidaoData.setNomeApresentante(result[0].nom_busca);
			certidaoData.setValorDeposito(
				formatterCurrency("pt-BR", "BRL", result[0].val_deposito),
			);

			const queryNatureza = `SELECT * FROM natureza_cer WHERE cod_nat_cert = ${result[0].cod_nat_cert}`;
			const resultNatureza = await query(queryNatureza);
			certidaoData.setNomeNatureza(resultNatureza[0].nom_nat_cert);

			break;
		case "CERTIDAO DE TD":
			// Get data from table "CERTIDAO_CASAMENTO"
			break;
		case "CERTIDAO DE PJ":
			// Get data from table "CERTIDAO_OBITO"
			break;
		default:
			console.log("Invalid CERTIDAO type");
	}

	return certidaoData;
}

async function getStatusCertidao(codCertRi, datProtoRi) {
	const status = [
		{ data: datProtoRi, status: "Entrada" },
		{ data: "Aguardando", status: "Busca em Processo" },
		{ data: "Aguardando", status: "Disponivel" },
	];

	const queryStatus = `SELECT * FROM remes_cert WHERE cod_cert_ri1 = '${codCertRi}'`;

	const resultStatus = await query(queryStatus);

	const dataMontagem = resultStatus.filter(
		(obj) => obj.cod_setor_d === "51" || obj.cod_setor_d === "57",
	);

	if (dataMontagem.length > 0)
		status[1].data = formatDateBR(dataMontagem[0].dat_remessa);

	const dataMontagemDisponivel = resultStatus.filter(
		(obj) => obj.cod_setor_d === "49",
	);

	if (dataMontagemDisponivel.length > 0)
		status[2].data = formatDateBR(dataMontagemDisponivel[0].dat_remessa);

	return status;
}

export { getDataCertidao, getStatusCertidao };
