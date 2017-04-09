<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-03-31 03:23:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2017-03-31 03:45:18 --> Query error: Unknown column 'CP.NomeContatoProf' in 'field list' - Invalid query: 
            SELECT
                P.idApp_Profissional,
                P.NomeProfissional,
				P.Funcao,
                P.DataNascimento,
                P.Telefone1,
                P.Telefone2,
                P.Telefone3,
                P.Sexo,
                P.Endereco,
                P.Bairro,
                CONCAT(M.NomeMunicipio, "/", M.Uf) AS Municipio,
                P.Email,
				CP.NomeContatoProf,
				CP.RelaPes,
				CP.Sexo

            FROM
                App_Profissional AS P
                    LEFT JOIN Tab_Municipio AS M ON P.Municipio = M.idTab_Municipio

            WHERE
                P.idSis_Usuario = 33


            ORDER BY
                P.NomeProfissional ASC
        
