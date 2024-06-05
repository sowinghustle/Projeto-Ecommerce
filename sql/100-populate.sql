INSERT INTO
    users (username, email, password)
VALUES (
        "user",
        "user@email.com",
        "12345678"
    ),
    (
        "admin",
        "admin@email.com",
        "12345678"
    );

INSERT INTO
    books (
        title,
        author,
        categories,
        price,
        description,
        user
    )
VALUES (
        "Learn Python in One Day and Learn it Well",
        "Jamie Chan",
        "programming",
        30.00,
        "Dive into the world of Python programming with this concise and comprehensive guide designed for beginners. 'Learn Python in One Day and Learn it Well' is your fast-track ticket to mastering Python fundamentals and kickstarting your programming journey.",
        1
    ),
    (
        "I Am Number Four",
        "Lore Pittacus",
        "action,adventure,science fiction,thriller",
        24.60,
        "Nove crianças e seus guardiões fugiram do planeta Lorien, onde estas crianças receberam um numero e foram protegidos com uma magia onde so podem ser mortos em ordem, para se esconder na Terra. O objetivo era se esconder dos Mogadorianos, inimigos que precisam eliminar todos eles - e na ordem certa - para que poderes especiais não possam ser usados contra eles no futuro. Três já morreram.",
        1
    ),
    (
        "The Mysterious Island",
        "Julio Verne",
        "science fiction,adventure,scientific novel",
        27.93,
        "Depois de sequestrar um balão de um campo confederado, um grupo de cinco abolicionistas americanos cai das nuvens em uma ilha vulcanica desconhecida no oceano Pacífico. Agora, precisam lutar pela própria sobrevivência. Juntos eles se empenham em construir uma colonia do zero, mas a ilha de recursos abundantes tem segredos inimagináveis.",
        2
    );

INSERT into
    sales (
        book,
        quantity,
        price,
        available
    )
VALUES (1, 1, 30.00, TRUE);