import mysql from 'mysql2/promise';

import dotenv from "dotenv";
dotenv.config();

let connection;

async function getConnection() {
    if (!connection) {
        connection = await mysql.createConnection({
            host: process.env.DB_HOST,
            user: process.env.DB_USER,
            password: process.env.DB_PASS,
            database: process.env.DATABASE
        });
    }

    return connection;
}

async function authenticate() {
    const connection = await getConnection();
    await connection.ping();
  }
  
  module.exports = { getConnection, authenticate };