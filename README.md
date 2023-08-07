# # Contabilizador de Chamados

Este é um sistema de contabilização de chamados que permite gerenciar e visualizar informações sobre chamados de suporte técnico, relacionando-os a erros de tela e realizando contagem por tela.

## Funcionalidades

- Listagem de chamados com detalhes como número, data, tipo de sistema, tela, descrição do chamado e erro da tela associado.
- Cores aleatórias associadas a cada tela para facilitar a identificação.
- Botões de edição e exclusão para cada chamado.
- Contagem de chamados por erro de tela.
- Contagem de chamados por tela.

## Pré-requisitos

- Servidor web (por exemplo, XAMPP, WAMP, etc.).
- Banco de dados MariaDB/MySQL.
- PHP 7 ou superior.

## Instalação

1. Clone este repositório: `git clone https://github.com/seu-usuario/contabilizador-de-chamados.git`
2. Configure o servidor web para apontar para a pasta do projeto.
3. Importe o arquivo `database.sql` no seu banco de dados MariaDB/MySQL.

## Como Usar

1. Acesse a página inicial (`index.php`) para cadastrar novos chamados.
2. Acesse a página de listagem (`lista_chamados.php`) para visualizar e gerenciar os chamados.
3. Na página de listagem, você verá a lista de chamados com informações detalhadas, cores de tela associadas e botões de edição/exclusão.
4. Na parte inferior da página de listagem, você encontrará contagens de chamados por erro de tela e por tela.

## Contribuição

Sinta-se à vontade para contribuir com melhorias, correções de bugs ou novas funcionalidades. Basta criar um fork deste repositório, fazer as alterações e enviar um pull request.

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## Contato

Para sugestões, dúvidas ou colaborações, entre em contato pelo e-mail contato@example.com ou pelas redes sociais (@usuario).
