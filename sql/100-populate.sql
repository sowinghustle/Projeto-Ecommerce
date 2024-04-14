INSERT INTO users (
    username, 
    email,
    password
) VALUES (
    "user",
    "user@email.com",
    "12345678"
),
(
    "admin",
    "admin@email.com",
    "12345678"
);

INSERT INTO books (
    title,
    author,
    categories,
    price,
    description,
    user
) VALUES (
    "Learn Python in One Day and Learn it Well",
    "Jamie Chan",
    "programming",
    30.00,
    "",
    1
),
(
    "I Am Number Four",
    "Lore Pittacus",
    "action,adventure,science fiction,thriller",
    24.60,
    "Nove criancas e seus guardioes fugiram do planeta Lorien, onde estas criancas receberam um numero e foram protegidos com uma magia onde so podem ser mortos em ordem, para se esconder na Terra. O objetivo era se esconder dos Mogadorianos, inimigos que precisam eliminar todos eles - e na ordem certa - para que poderes especiais nao possam ser usados contra eles no futuro. Tres ja morreram.",
    1
),
(
    "The Mysterious Island",
    "Júlio Verne",
    "science fiction,adventure,scientific novel",
    27.93,
    "Depois de sequestrar um balao de um campo confederado, um grupo de cinco abolicionistas americanos cai das nuvens em uma ilha vulcanica desconhecida no oceano Pacifico. Agora, precisam lutar pela propria sobrevivencia. Juntos eles se empenham em construir uma colonia do zero, mas a ilha de recursos abundantes tem segredos inimaginaveis.",
    2
);
