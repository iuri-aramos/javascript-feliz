export default class StatusCertidao {
	constructor(status = [{ data: "Aguardando", status: "Entrada"}, {data: "Aguardando", status: "Busca em Processo"}, {data: "Aguardando", status: "Disponivel"}]) {
		this.status = status;
	}

    setData(newData, statusToUpdate) {
        const statusObject = this.status.find(statusObject => statusObject.status === statusToUpdate);
        if (statusObject) {
            statusObject.data = newData;
        }
    }
}