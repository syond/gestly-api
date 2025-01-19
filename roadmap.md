# App para postagem de anúncios

## features back
### Posts
- [x] persistência de post;
- [x] persistência de medias vinculadas ao post;
- [x] eager loading para medias vinculadas;
- [x] persistência de interações com o post (like, favorite, etc...);
- [x] eager loading para categoria vinculada;
- [x] eager loading para interações (talvez, não sei);
- [ ] armazenar um "draft" de posts que não terminou de criar;
- [ ] alterar coluna `address` para ser chave estrangeira da tabela Address;

### Post Interactions
- [ ] revisar o metodo update do controller, pelo visto so vai servir para atualizar se o tipo de interação for `INTERACTION_TYPE_RATE`;
- [ ] add metodo `delete` para todos os `INTERACTION_TYPE !== 3`;

### Medias
- [x] persistência;

### Users
- [x] persistência;
- [ ] adicionar mais colunas de informação de contato;

### Address
- [ ] criar migration e relacionar com tabela users;
- [ ] decidir se os dados de geolocalização vão ficar nessa ou em outra tabela;

### Categories
- [x] persistência;

### Form
- [x] criar feature para construir formulários dinâmicos que serão utilizados pelas categorias;




## features front
- [ ] Post
    - titulo
    - descrição
        - não deve permitir inserir URLs ou qualquer tipo de endereço web no texto
    - imagens
        - deve ser uma geleria
        - não deve permitir inserir URLs ou qualquer tipo de endereço web na imagem
    - data de criação
    - data de atualização
    - endereço (caso precise)
        - integração com google maps
    - favorite **(postergado)**
    - hide **(postergado)**
    - flag **(postergado)**
    - share **(postergado)**
    - contato
        - informações de contato de quem postou
    - categoria
    - filtros
        - preço (mínimo/máximo)
        - mais recentos e mais antigos
        - postado nos ultimos 30 dias
        - postado a mais de 30 dias
        - menor para o maior preço (e vice-versa)
        - tem fotos
        - busca simples (por título)


- [ ] Category
    - nome