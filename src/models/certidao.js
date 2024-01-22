export default class Certidao {
	constructor(
		codSenha,
		codCertRi,
		nomeApresentante,
		nomeNatureza,
		numProtoRi,
		datProtoRi,
		dataUltimaAtualizacao,
		valorDeposito,
	) {
		this.codSenha = codSenha;
		this.codCertRi = codCertRi;
		this.nomeApresentante = nomeApresentante;
		this.nomeNatureza = nomeNatureza;
		this.numProtoRi = numProtoRi;
		this.datProtoRi = datProtoRi;
		this.dataUltimaAtualizacao = dataUltimaAtualizacao;
		this.valorDeposito = valorDeposito;
	}

	setCodSenha(codSenha) {
		this.codSenha = codSenha;
	}

	setCodCertRi(codCertRi) {
		this.codCertRi = codCertRi;
	}

	setNomeApresentante(nomeApresentante) {
		this.nomeApresentante = nomeApresentante;
	}

	setNomeNatureza(nomeNatureza) {
		this.nomeNatureza = nomeNatureza;
	}

	setNumProtoRi(numProtoRi) {
		this.numProtoRi = numProtoRi;
	}

	setDatProtoRi(datProtoRi) {
		this.datProtoRi = datProtoRi;
	}

	setDataUltimaAtualizacao(dataUltimaAtualizacao) {
		this.dataUltimaAtualizacao = dataUltimaAtualizacao;
	}

	setValorDeposito(valorDeposito) {
		this.valorDeposito = valorDeposito;
	}
}
