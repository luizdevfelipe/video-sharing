#!/bin/bash
set -e

# Aguarda o PostgreSQL ficar pronto
until pg_isready -U "$POSTGRES_USER" -d "$POSTGRES_DB"; do
  echo "Aguardando o PostgreSQL iniciar..."
  sleep 2
done

# Verifica se o banco 'testing' existe
DB_EXISTS=$(psql -U "$POSTGRES_USER" -tAc "SELECT 1 FROM pg_database WHERE datname='testing'")

if [ "$DB_EXISTS" != "1" ]; then
  echo "Criando banco de dados 'testing'..."
  createdb -U "$POSTGRES_USER" testing
else
  echo "Banco de dados 'testing' já existe."
fi
