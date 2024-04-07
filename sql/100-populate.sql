INSERT INTO clients (
    username, 
    email,
    password,
    is_admin
) VALUES (
    "user",
    "user@email.com",
    "12345678",
    false
),
(
    "admin",
    "admin@email.com",
    "12345678",
    true
);

INSERT INTO books (
    title,
    author,
    isbn,
    categories,
    price,
    description
) VALUES (
    "Learn Python in One Day and Learn it Well",
    "Jamie Chan",
    "1506094384",
    "programming",
    30.00,
    ""
),
(
    "I Am Number Four",
    "Lore Pittacus",
    "0061969559",
    "action,adventure,science fiction,thriller",
    24.60,
    "Nove crianças e seus guardiões fugiram do planeta Lorien, onde estas crianças receberam um número e foram protegidos com uma mágia onde só podem ser mortos em ordem, para se esconder na Terra. O objetivo era se esconder dos Mogadorianos, inimigos que precisam eliminar todos eles - e na ordem certa - para que poderes especiais não possam ser usados contra eles no futuro. Três já morreram."
),
(
    "The Mysterious Island",
    "Júlio Verne",
    "1405878622",
    "science fiction,adventure,scientific novel",
    27.93,
    "Depois de sequestrar um balão de um campo confederado, um grupo de cinco abolicionistas americanos cai das nuvens em uma ilha vulcânica desconhecida no oceano Pacífico. Agora, precisam lutar pela própria sobrevivência. Juntos eles se empenham em construir uma colônia do zero, mas a ilha de recursos abundantes tem segredos inimagináveis."
);
