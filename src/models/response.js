export default class Response {
	constructor(tipoDocumento, status = []) {
		this.tipoDocumento = tipoDocumento;
		this.status = status;
	}

	setCertidao(certidao) {
		this.certidao = certidao;
	}

	setTitulo(titulo) {
		this.titulo = titulo;
	}

	setStatus(status) {
		this.status = status;
	}
}
