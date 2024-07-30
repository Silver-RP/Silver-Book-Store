DROP DATABASE IF EXISTS `Silver-Book`;	

CREATE DATABASE `Silver-Book`;
USE `Silver-Book`;

select * from category c;
select * from book b;
select * from author a;
select * from publisher p;
select * from users u;	
select * from wishlist w;			
select * from orders o;
select * from cart c ;
select * from review  r;

SELECT * FROM book WHERE book_title LIKE '%a%';


drop table users ;
drop table orders  ;
drop table order_detail  ;
drop table comments  ;
drop table wishlist  ;
drop table cart  ;
drop table cartbook  ;

delete from author where id = 1000;
delete from wishlist ;
delete from users;
update author set author_id = 1 where author_id = 1000;

CREATE TABLE category (
    cate_id INT AUTO_INCREMENT PRIMARY KEY,
    cate_name VARCHAR(100) NOT NULL,
    cate_description VARCHAR(255),
    cate_image VARCHAR(255),
    cate_note VARCHAR(255)
);

CREATE TABLE author (
    author_id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(100) NOT NULL,
    author_phone VARCHAR(20) NOT NULL,
    author_email VARCHAR(200) NOT NULL,
    author_address VARCHAR(255) NOT NULL,
    author_note VARCHAR(255)
);

CREATE TABLE publisher (
    publisher_id INT AUTO_INCREMENT PRIMARY KEY,
    publisher_name VARCHAR(255) NOT NULL,
    publisher_address VARCHAR(255) NOT NULL,
    publisher_phone VARCHAR(20) NOT NULL,
    publisher_email VARCHAR(200) NOT NULL,
    publisher_url VARCHAR(255) NOT NULL
);

CREATE TABLE book (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(255) NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    book_image VARCHAR(255) NOT NULL,
    book_description TEXT NOT NULL,
    book_year_of_publication YEAR NOT NULL,
    book_price DOUBLE NOT NULL,
    book_old_price DOUBLE NOT NULL,
    book_date_of_storage DATE NOT NULL,
    book_stock_quantity INT NOT NULL,
    cate_id INT NOT NULL,
    author_id INT NOT NULL,
    publisher_id INT NOT NULL,
    FOREIGN KEY (cate_id) REFERENCES category(cate_id),
    FOREIGN KEY (author_id) REFERENCES author(author_id),
    FOREIGN KEY (publisher_id) REFERENCES publisher(publisher_id)
);
ALTER TABLE book ADD COLUMN book_old_price DOUBLE NOT NULL;
ALTER TABLE book MODIFY book_old_price DOUBLE NULL;
update book set book_old_price = book_price + 20;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    user_birthday VARCHAR(50) NOT NULL,
    user_gender VARCHAR(50) NOT NULL,
    user_email_phone VARCHAR(20) NOT NULL,
    user_password VARCHAR(100) NOT NULL,
    user_role VARCHAR(20) NOT NULL default 1, 	 -- 0 is admin, 1 is user 
    user_date_register TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    wish_status INT NOT NULL DEFAULT 1,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES book(book_id),
    UNIQUE (user_id, book_id),  
    INDEX (user_id),            
    INDEX (book_id)            
);
-- Case: A user has a cart
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    status VARCHAR(20) DEFAULT 'active',
    cart_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES book(book_id)
);

-- Case: A user can have many cart
 CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_name VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    cart_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE cartbook (
    cartproduct_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id),
    FOREIGN KEY (book_id) REFERENCES book(book_id)
); 
 
-- --------------

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_date DATE NOT NULL,
    order_total_amount DOUBLE NOT NULL,
    order_status VARCHAR(20) NOT NULL,
    order_user_id INT NOT NULL,
    FOREIGN KEY (order_user_id) REFERENCES users(user_id)
);

CREATE TABLE review (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    review_content TEXT NOT NULL,
    review_rating INT NOT NULL,
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    book_id INT,
    review_status INT DEFAULT 1, 
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (book_id) REFERENCES book(book_id) ON DELETE CASCADE
);

CREATE TABLE order_detail (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    order_id INT NOT NULL,
    book_name VARCHAR(255) NOT NULL,
    unit_price DOUBLE NOT NULL,
    unit_quantity INT NOT NULL,
    total_quantity INT NOT NULL,
    total_number_of_item_types INT NOT NULL,
    total_price DOUBLE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES book(book_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);


INSERT INTO category (cate_name, cate_description, cate_image, cate_note)
VALUES 
    ('Fiction', 'Books of fictional stories', '', ''),
    ('Non-Fiction', 'Books based on real facts', '', ''),
    ('Science', 'Books on scientific topics', '', ''),
    ('Education', 'Books related to educational topics', '', ''),
    ('Business and Management', 'Books on business strategies', '', ''),
    ('History', 'Books on historical events', '', ''),
    ('Travel', 'Books about traveling and destinations', '', ''),
    ('Fantasy', 'Books with elements of fantasy', '', ''),
    ('Science Fiction', 'Books with futuristic or scientific themes', '', ''),
    ('Mystery', 'Books involving mystery and suspense', '', ''),
    ('Thriller', 'Books filled with tension and excitement', '', ''),
    ('Romance', 'Books centered around romantic relationships', '', ''),
    ('Historical Fiction', 'Books with fictional stories set in historical settings', '', ''),
    ('Horror', 'Books designed to evoke fear and suspense', '', ''),
    ('Biography', 'Books detailing the life stories of real people', '', ''),
    ('Autobiography', 'Books written by the authors about themselves', '', ''),
    ('Memoir', 'Books recounting personal experiences', '', ''),
    ('Cookbook', 'Books containing recipes and culinary tips', '', ''),
    ('Poetry', 'Books filled with poetic verses and writings', '', '');

INSERT INTO publisher (publisher_name, publisher_address, publisher_phone, publisher_email, publisher_url)
VALUES
    ('Big Publishing House', '100 Publisher Ave, Bigtown, USA', '800-123-4567', 'info@bigpublishing.com', 'http://www.bigpublishing.com'),
    ('Small Press Inc.', '200 Press St, Smalltown, USA', '888-555-1234', 'contact@smallpress.com', 'http://www.smallpress.com'),
    ('Academic Books Ltd.', '300 Academic Blvd, Booksville, USA', '999-777-2345', 'support@academicbooks.com', 'http://www.academicbooks.com'),
    ('Tech Publishing Solutions', '400 Tech St, Technocity, USA', '666-222-9876', 'techsupport@techpublishing.com', 'http://www.techpublishing.com'),
    ('Adventure Publications', '500 Adventure Rd, Adventuretown, USA', '555-444-2222', 'adventure@adventurepubs.com', 'http://www.adventurepubs.com'),
    ('Children Books Co.', '600 Children Ave, Kidstown, USA', '333-666-1111', 'info@childrenbooksco.com', 'http://www.childrenbooksco.com'),
    ('Romantic Reads Ltd.', '700 Romance St, Lovetown, USA', '111-999-8888', 'romance@romanticreads.com', 'http://www.romanticreads.com'),
    ('Riverhead Books', '123 Riverhead Lane, New York, NY', '+1-212-555-1234', 'contact@riverheadbooks.com', 'http://www.riverheadbooks.com'),
    ('Penguin Random House', '375 Hudson Street, New York, NY', '+1-212-555-5678', 'info@penguinrandomhouse.com', 'http://www.penguinrandomhouse.com'),
    ('Scribner', '1230 Avenue of the Americas, New York, NY', '+1-212-555-9876', 'info@scribner.com', 'http://www.scribner.com'),
    ('Knopf Doubleday Publishing Group', '1745 Broadway, New York, NY', '+1-212-555-4321', 'info@randomhousebooks.com', 'http://www.randomhousebooks.com');

INSERT INTO author (author_name, author_phone, author_email, author_address, author_note)
VALUES
    ('Kristin Hannah', '123-456-7890', 'Kristinhannah@example.com', '123 Main St, Anytown, USA', ''),
    ('Rebecca Yarros', '987-654-3210', 'Rebeccayarros@example.com', '456 Elm St, Othertown, USA', ''),
    ('Annie Spence', '123-456-7890', 'Anniespence@example.com', '123 Main St, Anytown, USA', ''),
    ('Matt Eversmann', '234-567-8901', 'Matteversmann@example.com', '456 Elm St, Othertown, USA', ''),
    ('DK', '345-678-9012', 'DK@example.com', '789 Oak St, Anytown, USA', ''),
    ('Wonder House Books ', '456-789-0123', 'Wonderhousebooks @example.com', '101 Pine St, Othertown, USA', ''),
    ('Barbara Oakley PhD', '567-890-1234', 'BarbaraoakleyphD@example.com', '202 Maple St, Anytown, USA', ''),
    ('Tara Westover ', '678-901-2345', 'Tarawestover@example.com', '303 Cedar St, Othertown, USA', ''),
    ('James Clear', '789-012-3456', 'Jamesclear@example.com', '404 Birch St, Anytown, USA', ''),
    ('Morgan Housel', '890-123-4567', 'Morganhousel@example.com', '505 Spruce St, Othertown, USA', ''),
    ('Stanley Karnow', '901-234-5678', 'Stanleykarnow@example.com', '606 Fir St, Anytown, USA', ''),
    ('Travel Essentials Books ', '012-345-6789', 'Travelsssentialsbooks@example.com', '707 Willow St, Othertown, USA', ''),
    ('National Geographic', '123-456-7890', 'Nationalgeographic@example.com', '808 Poplar St, Anytown, USA', ''),
    ('Elizabeth Jackson', '234-567-8901', 'elizabeth.jackson@example.com', '909 Redwood St, Othertown, USA', ''),
    ('Christopher White', '345-678-9012', 'christopher.white@example.com', '1010 Cypress St, Anytown, USA', ''),
    ('Jessica Harris', '456-789-0123', 'jessica.harris@example.com', '1111 Ash St, Othertown, USA', ''),
    ('Paul Martin', '567-890-1234', 'paul.martin@example.com', '1212 Palm St, Anytown, USA', ''),
    ('Nancy Thompson', '678-901-2345', 'nancy.thompson@example.com', '1313 Magnolia St, Othertown, USA', ''),
    ('Kevin Garcia', '789-012-3456', 'kevin.garcia@example.com', '1414 Juniper St, Anytown, USA', ''),
    ('Linda Martinez', '890-123-4567', 'linda.martinez@example.com', '1515 Dogwood St, Othertown, USA', ''),
    ('Brian Clark', '901-234-5678', 'brian.clark@example.com', '1616 Olive St, Anytown, USA', ''),
    ('Kimberly Lewis', '012-345-6789', 'kimberly.lewis@example.com', '1717 Laurel St, Othertown, USA', ''),
	('Paula Hawkins', '+44-20-555-1234', 'paula.hawkins@example.com', 'London, UK', 'Bestselling author of psychological thrillers.'),
    ('Alex Michaelides', '+1-310-555-6789', 'alex.michaelides@example.com', 'Los Angeles, CA', 'Author known for gripping psychological mysteries.'),
    ('Jane Austen', '+44-1273-555-9876', 'jane.austen@example.com', 'Hampshire, UK', 'Renowned for classic novels exploring love and society.'),
    ('Nicholas Sparks', '+1-910-555-4321', 'nicholas.sparks@example.com', 'New Bern, NC', 'Celebrated author of romantic novels and dramas.');
    
INSERT INTO book (book_name, book_title, book_image, book_description, book_year_of_publication, book_price, book_date_of_storage, book_stock_quantity, cate_id, author_id, publisher_id)
VALUES
    ('The Women: A Novel', 'Fiction Book: The Women at War', 'f_TheWoman.webp', 'Women can be heroes. When twenty-year-old nursing student Frances “Frankie” McGrath hears these words, it is a revelation. Raised in the sun-drenched, 
	idyllic world of Southern California and sheltered by her conservative parents, she has always prided herself on doing the right thing. But in 1965, the world is changing, and she suddenly dares to imagine a different future for herself. 
	When her brother ships out to serve in Vietnam, she joins the Army Nurse Corps and follows his path.
	As green and inexperienced as the men sent to Vietnam to fight, Frankie is over-whelmed by the chaos and destruction of war. Each day is a gamble of life and death, hope and betrayal; friendships run deep and can be shattered in an instant. 
	In war, she meets—and becomes one of—the lucky, the brave, the broken, and the lost.
	But war is just the beginning for Frankie and her veteran friends. The real battle lies in coming home to a changed and divided America, to angry protesters, and to a country that wants to forget Vietnam.
	The Women is the story of one woman gone to war, but it shines a light on all women who put themselves in harm’s way and whose sacrifice and commitment to their country has too often been forgotten. A novel about deep friendships and bold patriotism, 
	The Women is a richly drawn story with a memorable heroine whose idealism and courage under fire will come to define an era.'
    , 2023, 29.99, '2023-05-15', 100, 1, 1, 1),
    ('Onyx Storm (Deluxe Limited Edition)', 'Fiction Book: Onyx Storm: Deluxe Edition', 'f_OnyxStorm.webp', 'Preorder now and receive the stunning DELUXE LIMITED EDITION while supplies last―featuring gorgeous sprayed edges with stenciled artwork, 
	as well as exclusive special design features. This incredible collectible is only available for a limited time, a must-have for any book lover while supplies last in the US and Canada only.
	Get ready to fly or die in the breathtaking follow-up to Fourth Wing and Iron Flame from #1 New York Times bestselling author Rebecca Yarros.'
    , 2022, 24.99, '2022-11-20', 80, 1, 2, 1),
    ('Dear Fahrenheit 451: Love and Heartbreak in the Stacks', 'Non-Fiction Book: Dear Fahrenheit 451', 'n_DearFahrenheit.webp', 'If you love to read, and presumably you do since you’ve picked up this book,
	 you know that some books affect you so profoundly they forever change the way you think about the world. Some books, on the other hand, disappoint you so much you want to throw them against the wall. Either way,
	 it’s clear that a book can be your new soul mate or the bad relationship you need to end.
	In Dear Fahrenheit 451, librarian Annie Spence has crafted love letters and breakup notes to the iconic and eclectic books she has encountered over the years. 
	From breaking up with The Giving Tree (a dysfunctional relationship book if ever there was one), to her love letter to The Time Traveler’s Wife (a novel less about time travel and more about the life of a marriage, 
	with all of its ups and downs), Spence will make you think of old favorites in a new way. Filled with suggested reading lists, Spence’s take on classic and contemporary books is very much like 
	the best of literature—sometimes laugh-out-loud funny, sometimes surprisingly poignant, and filled with universal truths.'
    , 2021, 34.99, '2021-09-10', 120, 2, 3, 2),
    ('The Secret Lives of Booksellers and Librarians', 'Non-Fiction Book: The Secret Lives of Booksellers', 'n_TheSecretLives.webp', 
     'Step inside The Secret Lives of Booksellers and Librarians and enter a world where you can feed your curiosities, \n'
     'discover new voices, find whatever you want or require. This place has the magic of rainbows and unicorns, but it\'s also a business. The book business.',
     2020, 39.99, '2020-07-05', 150, 2, 4, 2),
    ('The Science Book', 'Science Book: The Science Book: A Journey Through Discovery', 's_TheScienceBook.webp', 
     'Part of the popular Big Ideas series, The Science Book explores the history of science, how scientists have sought to explain our incredible universe and how amazing scientific discoveries have been made.\n'
     'Discover how Galileo worked out his scientific theories of motion and inertia, why Copernicus\'s ideas were contentious and what the discovery of DNA meant. All the big scientific ideas and discoveries are brought to life with quirky graphics, \n'
     'pithy quotes and step-by-step \'mind maps\', plus every area of science is covered, including astronomy, biology, chemistry, geology, maths and physics. You\'ll be brought up-to-date on scientific ideas from black holes to genetic engineering with \n'
     'eye-catching artworks showing how the ideas of key scientists have impacted our understanding of the world.',
     2019, 29.99, '2019-04-02', 200, 3, 5, 3),
    ('Science Knowledge Encyclopedia for Children', 'Science Book: Science Knowledge Encyclopedia', 's_Science.jpg', 
     'What is the Theory of Evolution? How do chemical reactions occur? Why is the human eye most receptive to only three colours? \n'
     'Get ready to explore the fascinating world of science in this boxset of six encyclopedias. Well-labelled diagrams, and an extensive glossary of difficult words come as happy bonuses in these informative books.',
     2018, 34.99, '2018-01-15', 90, 3, 6, 3),
    ('Uncommon Sense Teaching', 'Education Book: Uncommon Sense Teaching', 'e_uncommon.jpg', 
     'Neuroscientists and cognitive scientists have made enormous strides in understanding the brain and how we learn, but little of that insight has filtered down to \n'
     'the way teachers teach. Uncommon Sense Teaching applies this research to the classroom for teachers, parents, and anyone interested in improving education. Topics include:\n'
     '• keeping students motivated and engaged, especially with online learning\n'
     '• helping students remember information long-term, so it isn\'t immediately forgotten after a test\n'
     '• how to teach inclusively in a diverse classroom where students have a wide range of abilities\n'
     'Drawing on research findings as well as the authors\' combined decades of experience in the classroom, Uncommon Sense Teaching equips readers with the tools to enhance their teaching, whether they\'re seasoned professionals or \n'
     'parents trying to offer extra support for their children\'s education.',
     2017, 24.99, '2017-08-20', 110, 4, 7, 4),
    ('Educated: A Memoir', 'Educated: A Journey to Knowledge', 'e_educated.jpg', 
     'Born to survivalists in the mountains of Idaho, Tara Westover was seventeen the first time she set foot in a classroom. \n'
     'Her family was so isolated from mainstream society that there was no one to ensure the children received an education, and no one to intervene when one of Tara’s older brothers became violent. \n'
     'When another brother got himself into college, Tara decided to try a new kind of life. Her quest for knowledge transformed her, taking her over oceans and across continents, to Harvard and to Cambridge University. \n'
     'Only then would she wonder if she’d traveled too far, if there was still a way home.',
     2016, 19.99, '2018-03-25', 80, 4, 8, 4),
    ('Atomic Habits: An Easy & Proven Way to Build Good Habits & Break Bad Ones', 'Business Book: Atomic Habits: Mastering Change', 'b_atomic.webp', 
     'No matter your goals, Atomic Habits offers a proven framework for improving--every day. \n'
     'James Clear, one of the world\'s leading experts on habit formation, reveals practical strategies that will teach you exactly how to form good habits, break bad ones, and master the tiny behaviors that lead to remarkable results.\n'
     'If you\'re having trouble changing your habits, the problem isn\'t you. The problem is your system. Bad habits repeat themselves again and again not because you don\'t want to change, but because you have the wrong system for change. \n'
     'You do not rise to the level of your goals. You fall to the level of your systems. Here, you\'ll get a proven system that can take you to new heights.',
     2015, 39.99, '2022-10-10', 150, 5, 5, 5),
    ('The Psychology of Money', 'The Psychology of Money', 'b_ThePsychology.jpg', 
     'Money - investing, personal finance, and business decisions - is typically taught as a math-based field, where data and formulas tell us exactly what to do. \n'
     'But in the real world people don’t make financial decisions on a spreadsheet. They make them at the dinner table, or in a meeting room, where personal history, your own unique view of the world, ego, pride, marketing, and odd incentives are scrambled together.',
     2014, 44.99, '2021-07-15', 120, 5, 9, 5),
    ('Vietnam: A History', 'History Book Vietnam: An American Tragedy', 'h_vietnam.webp', 
     'In this comprehensive history, Stanley Karnow demystifies the tragic ordeal of America\'s war in Vietnam. The book\'s central theme is that America\'s leaders, prompted as much by \n'
     'domestic politics as by global ambitions, carried the United States into Southeast Asia with little regard for the realities of the region. Karnow elucidates the decision-making process in Washington and Asia, and recounts the political and \n'
     'military events that occurred after the Americans arrived in Vietnam.',
     2013, 29.99, '2023-04-02', 100, 6, 10, 6),
    ('The Vietnam War', 'History Book: The Vietnam War: A Visual History', 'h_VNwar.jpg', 
     'The definitive telling of one of the longest and most controversial wars in US history. \n'
     'Delve into the compelling history and impact of the Vietnam War in reverting detail. This authoritative visual guide unpacks accounts of struggle, sacrifice, and bravery, making this a perfect read for any military history enthusiast.',
     2012, 34.99, '2022-01-15', 80, 6, 11, 6),
    ('Venice & Veneto Travel Guide', 'Travel Book: Venice & Veneto Revealed', 't_venice.jpg', 
     'Ready to uncover Venice\'s best-kept secrets? Want to explore Veneto like a local?\n'
     'Curious about hidden courtyards, secret frescoes, and authentic experiences that won\'t break the bank?\n'
     'This pocket-sized guide is your passport to Venice and Veneto most travelers never see. Packed with 101 unique secrets, insider tips, and budget-friendly strategies, it\'s designed for curious adventurers who want to delve deeper without emptying their wallets.',
     2011, 24.99, '2023-08-20', 120, 7, 13, 7),
   ('Destinations of a Lifetime', 'Destinations of a Lifetime', 't_destinations.jpg', 
     'NatGeo takes you on a photographic tour of the world’s most spectacular destinations, inspiring tangible ideas for your next trip.\n'
     'Travel to hundreds of the most breathtaking locales—both natural and man-made—illustrated with vivid images taken by the organization\'s world-class photographers. These images, coupled with evocative text, feature a plethora of \n'
     'visual wonders: ancient monoliths, scenic islands, stunning artwork, electric cityscapes, white-sand seashores, rain forests, ancient cobbled streets, and both classic and innovative architecture.',
     2010, 19.99, '2024-03-25', 90, 7, 14, 7);
    
INSERT INTO book (book_name, book_title, book_image, book_description, book_year_of_publication, book_price, book_date_of_storage, book_stock_quantity, cate_id, author_id, publisher_id)
VALUES
    ('Harry Potter and the Sorcerer\'s Stone', 'Fantasy: The Beginning of a Magical Journey', 'fa_harry_potter.jpeg', 'Follow young Harry Potter as he discovers his magical heritage and begins his journey at Hogwarts School of Witchcraft and Wizardry.', 1997, 19.99, '2023-06-26', 150, 8, 18, 8),
    ('The Name of the Wind', 'Fantasy: A Tale of Magic and Adventure', 'fa_name_of_the_wind.jpeg', 'Enter the world of Kvothe, a magically gifted young man who grows to be the most notorious wizard his world has ever seen.', 2007, 24.99, '2023-04-15', 120, 8, 19, 8),
    ('Dune', 'Science Fiction: Epic Saga of Power and Intrigue', 'si_fi_dune.jpeg', 'Explore the desert planet of Arrakis, where noble houses battle for control of the most valuable substance in the universe - the spice melange.', 1965, 29.99, '2023-08-01', 100, 9, 20, 9),
    ('Ender\'s Game', 'Science Fiction: Battle for Humanity\'s Future', 'si_fi_ender.jpeg', 'Join young Ender Wiggin as he trains in space combat to prepare for an imminent alien invasion threatening humanity.', 1985, 22.99, '2023-11-10', 80, 9, 21, 9),
     ('The Girl with the Dragon Tattoo', 'Mystery: Dark Secrets Unraveled', 'm_TheGirlwiththeDragonTattoo.jpeg', 'Investigate a cold case with journalist Mikael Blomkvist and hacker Lisbeth Salander in this gripping tale of murder, mystery, and intrigue.', 2005, 18.99, '2023-09-15', 90, 10, 22, 10),
    ('Gone Girl', 'Mystery: A Twisted Tale of Deception', 'm_GoneGirl.png', 'Discover the chilling story of Nick and Amy Dunne, whose marriage takes a dark turn when Amy goes missing on their fifth wedding anniversary.', 2012, 21.99, '2023-07-20', 110, 10, 14, 10),
    ('The Girl on the Train', 'Thriller: A Gripping Psychological Mystery', 'th_TheGirlontheTrain.jpeg', 'Follow Rachel as she becomes entangled in the investigation of a missing woman, blurring the lines between truth, lies, and her own memories.', 2015, 17.99, '2024-01-13', 120, 11, 10, 11),
    ('The Silent Patient', 'Thriller: Unraveling a Shocking Murder Mystery', 'th_TheSilentPatient.jpeg', 'Enter the mind of Alicia Berenson, who shot her husband five times and then never spoke another word. A psychotherapist is determined to unravel the truth.', 2019, 25.99, '2019-02-05', 100, 11, 8, 6),
    ('Pride and Prejudice', 'Romance: Classic Tale of Love and Misunderstanding', 'r_PrideandPrejudice.jpeg', 'Experience the timeless romance between Elizabeth Bennet and Mr. Darcy as they navigate societal expectations and their own prejudices.', 1993, 14.99, '2022-01-28', 150, 12, 6, 5),
    ('The Notebook', 'Romance: Heartwarming Story of Love and Devotion', 'r_TheNotebook.jpeg', 'Follow the love story of Noah and Allie, whose passionate romance spans decades, tested by life\'s challenges and the passage of time.', 1996, 16.99, '2023-10-01', 130, 12, 12, 5),
     ('The Book Thief', 'Historical Fiction: A Story of Courage and Hope', 'hi_hi_TheBookthief.jpeg', 'Narrated by Death, this novel tells the story of Liesel Meminger, a young girl living in Nazi Germany who steals books and shares them with others during the horrors of World War II.', 2005, 19.99, '2023-03-14', 110, 13, 11, 3),
    ('All the Light We Cannot See', 'Historical Fiction: Beauty Amidst the Chaos of War', 'hi_fi_AlltheLightWeCannotSee.jpeg', 'Discover the intersecting lives of a blind French girl and a German boy during the chaos of World War II, where their paths ultimately collide in a story of survival and resilience.', 2014, 23.99, '2023-05-06', 90, 13, 15, 3),
    ('It', 'Horror: A Terrifying Encounter with Pennywise the Clown', 'ho_It.jpeg', 'Follow the Losers\' Club as they face their worst nightmares in the form of Pennywise, an ancient evil entity that awakens every 27 years to prey on children.', 1986, 20.99, '2023-09-15', 100, 14, 13, 2),
    ('The Shining', 'Horror: A Haunting Tale of Madness and Malevolence', 'ho_TheShining.jpeg', 'Experience the descent into madness of Jack Torrance, his wife Wendy, and their young son Danny as they face the malevolent forces lurking within the haunted Overlook Hotel.', 1977, 18.99, '2023-01-28', 120, 14, 3, 2),
    ('Steve Jobs', 'Biography: The Life of a Visionary Entrepreneur', 'bi_SteveJobs.jpeg', 'Explore the life and career of Steve Jobs, co-founder of Apple Inc., from his early days to his revolutionary impact on technology, business, and innovation.', 2011, 26.99, '2023-10-24', 140, 15, 2, 1),
    ('Becoming', 'Biography: Inspirational Journey of Michelle Obama', 'bi_Becoming.jpeg', 'Follow Michelle Obama\'s journey from her childhood in Chicago to her years as First Lady of the United States, sharing her triumphs, challenges, and personal growth.', 2018, 28.99, '2023-11-13', 110, 15, 1, 1),
    ('Long Walk to Freedom', 'Autobiography: The Journey to Freedom', 'a_LongWalktoFreedom.jpeg', 'Discover Nelson Mandela\'s extraordinary journey from his childhood in rural Transkei to his struggle against apartheid and eventual presidency of South Africa.', 1994, 21.99, '2023-10-01', 100, 16, 20, 8),
    ('The Diary of a Young Girl', 'Autobiography: A Voice from the Holocaust', 'a_TheDiaryofaYoungGirl.jpeg', 'Read Anne Frank\'s diary, a poignant account of her life in hiding during the Nazi occupation of the Netherlands, offering a glimpse into the horrors of the Holocaust.', 1947, 15.99, '2023-06-25', 130, 16, 18, 8),
    ('Atomic Habits', 'An Easy & Proven Way to Build Good Habits & Break Bad Ones', 'me_AtomicHabits.png','No matter your goals, Atomic Habits offers a proven framework for improving--every day. James Clear, one of the world\'s leading experts on habit formation, reveals practical strategies that will teach you exactly how to form good habits, break bad ones, and master the tiny behaviors that lead to remarkable results. If you\'re having trouble changing your habits, the problem isn\'t you. The problem is your system. Bad habits repeat themselves again and again not because you don\'t want to change, but because you have the wrong system for change. You do not rise to the level of your goals. You fall to the level of your systems. Here, you\'ll get a proven system that can take you to new heights.',2018, 39.99, '2023-10-15', 100, 5, 8, 5),
    ('The Glass Castle', 'Memoir: Family Dysfunction and Resilience', 'me_TheGlassCastle.jpeg', 'Experience Jeannette Walls\'s upbringing in a dysfunctional family marked by poverty and instability, yet characterized by love, resilience, and hope.', 2005, 19.99, '2023-09-06', 140, 17, 22, 9),
    ('The Joy of Cooking', 'Cookbook: Classic Recipes for Every Cook', 'c_TheJoyofCooking.jpeg', 'Discover over 4,500 recipes ranging from traditional favorites to contemporary dishes, along with comprehensive cooking techniques and tips.', 1931, 29.99, '2023-11-17', 150, 18, 21, 10),
    ('Cravings: Recipes for All the Food You Want to Eat', 'Cookbook: Indulgent and Irresistible Dishes', 'c_cravings.jpeg', 'Explore a collection of recipes that are unapologetically indulgent, inspired by Chrissy Teigen\'s culinary cravings and family favorites.', 2016, 26.99, '2023-02-23', 130, 18, 20, 10),
    ('Milk and Honey', 'Poetry: Poems about Love, Loss, and Healing', 'p_MilkandHoney.jpeg', 'Experience Rupi Kaur\'s deeply personal collection of poetry exploring themes of femininity, love, trauma, and healing, accompanied by her own illustrations.', 2014, 15.99, '2014-11-04', 100, 19, 21, 11),
    ('The Sun and Her Flowers', 'Poetry: Reflections on Growth and Transformation', 'p_TheSunandHerFlowers.jpeg', 'Delve into Rupi Kaur\'s second collection of poetry, celebrating resilience, self-love, and the journey of growth amidst life\'s challenges and joys.', 2017, 18.99, '2023-10-03', 120, 19, 22, 11);

   

    