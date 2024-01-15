import db from "../database/connection.js";

async function main() {

    try {
        const connection = await db.getConnection();
        console.log('Connected to MySQL database.');

        const [results, fields] = await connection.execute('SELECT * FROM VW_PROTOCOLO_STATUS_NEW WHERE cod_senha = \'M2541000M\'');

        console.log(results);
        console.log(fields);
    }
    catch (error) {
        console.error(error);
    }
}