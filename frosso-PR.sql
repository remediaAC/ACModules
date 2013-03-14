-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 28 giu, 2010 at 05:29 PM
-- Versione MySQL: 5.1.37
-- Versione PHP: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `frosso-PR`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_album`
--

DROP TABLE IF EXISTS `mio_album`;
CREATE TABLE IF NOT EXISTS `mio_album` (
  `idAlbum` int(36) unsigned NOT NULL AUTO_INCREMENT,
  `nomeAlbum` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `annoPubblicazione` int(11) NOT NULL,
  `copertina` text COLLATE latin1_general_ci NOT NULL,
  `idArtista` int(36) NOT NULL,
  `prezzo` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idAlbum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `mio_album`
--

INSERT INTO `mio_album` (`idAlbum`, `nomeAlbum`, `annoPubblicazione`, `copertina`, `idArtista`, `prezzo`) VALUES
(1, 'Wish You Were Here', 1980, 'http://userserve-ak.last.fm/serve/126/40625357.png', 3, 19.9),
(2, 'Dark Side Of The Moon', 1979, 'http://thehelplessdancer.files.wordpress.com/2009/04/dark-side-of-the-moon.jpg', 3, 19.9),
(3, 'Animals', 1968, 'http://euclidespaim.files.wordpress.com/2008/07/pink_floyd-animals-frontal.jpg', 3, 19.9),
(4, 'Californication', 1999, 'http://www.testigratis.com/wp-content/uploads/2009/06/red_hot_chili_peppers_californication.jpg', 4, 19.9),
(5, 'Rage 1', 2010, '', 2, 0),
(6, 'Studentessi', 2009, 'http://www.ipercritica.com/wp-content/uploads/2009/10/studentessi1.jpg', 1, 0),
(7, 'Cicciput', 2006, 'http://braitaspa.files.wordpress.com/2009/12/cicciput.jpg', 1, 21.9),
(8, 'Eat The Phikis', 1996, 'http://www.elio.net/testi/phikis.jpg', 1, 19.9);

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_artisti`
--

DROP TABLE IF EXISTS `mio_artisti`;
CREATE TABLE IF NOT EXISTS `mio_artisti` (
  `idArtista` int(36) unsigned NOT NULL AUTO_INCREMENT,
  `nomeArtista` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `biografiaArtista` longtext COLLATE latin1_general_ci NOT NULL,
  `fotoArtista` text COLLATE latin1_general_ci,
  PRIMARY KEY (`idArtista`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=33 ;

--
-- Dump dei dati per la tabella `mio_artisti`
--

INSERT INTO `mio_artisti` (`idArtista`, `nomeArtista`, `biografiaArtista`, `fotoArtista`) VALUES
(1, 'Elio e Le Storie Tese', '<p>Gli Elio e le Storie Tese (talvolta abbreviato in EelST o Elii) sono un gruppo musicale italiano di Milano, fondato nel 1980.\r\n</p><p>\r\nIl gruppo ha conosciuto, nel tempo, una popolarita'' sempre crescente, alimentata prima dalla circolazione di registrazioni bootleg dei loro spettacoli in locali come il Magia Music Meeting e lo Zelig di Milano, poi dalla pubblicazione dei primi album e dalle numerose comparse in televisione (Lupo solitario, Matrioska e L''araba fenice su Italia 1, al seguito della Gialappa''s band in Mai dire gol o di Claudio Bisio a Zelig).</p>', 'http://userserve-ak.last.fm/serve/252/35816761.jpg'),
(2, 'Rage Against The Touring Machine', '<p>Gimpalappampero</p>', NULL),
(3, 'Pink Floyd', '<p>I Pink Floyd sono i pionieri della psichedelia e uno dei massimi complessi rock di sempre. Nel corso di una carriera lunghissima (in cui si distinguono tre fasi, corrispondenti ad altrettante formazioni) hanno ampliato i limiti del pop e del rock sposando l&rsquo;elettronica e approfondendo la ricerca sonora in una serie di album giudicati pietre miliari della musica del Novecento. Altra peculiarit&agrave; &egrave; quella di aver prodotto mastodontiche rappresentazioni multimediali della loro musica attraverso spettacoli in cui la componente visiva &egrave; parte integrante di quella sonora. <br /> <br /> La lunga storia della formazione inglese ha inizio a met&agrave; degli anni Sessanta, quando tre studenti di architettura e un estroso studente di pittura gettano le basi per entrare a pieno titolo nella leggenda del rock, partendo dai club della Londra underground e lisergica per arrivare, non senza radicali cambiamenti di stile e di formazione, al successo planetario. <br /> <br /> La band nasce dall&rsquo;incontro dello studente di pittura Roger Keith Barret (per tutti Syd, nato il 6/1/46 a Cambridge) con Roger Waters (Great Bookham - 9/9/44), studente di architettura e chitarrista di una formazione dal nome cangiante (Sigma 6, T-Set, Meggadeaths, Abdabs) nella quale suonavano altri due aspiranti architetti: Nick Mason (Birmingham - 21/1/45) e Rick Wright (Londra - 28/7/45) oltre al bassista Clive Metcalf e ai cantanti Keith Noble e Juliette Gale. Nel &lsquo;65, dopo lo scioglimento del gruppo, Waters (al basso), Barrett (chitarra), Wright (tastiere) e Mason (batteria) decidono di formare una band (per brevissimo tempo ne far&agrave; parte anche il chitarrista Bob Close): il nome, scelto da Barrett, &egrave; Pink Floyd e deriva dai nomi di battesimo di due bluesmen americani, Pink Anderson e Floyd Council. <br /> <br /> Nel &lsquo;66 arriva il momento delle prime esibizioni nei club della Londra underground, con un repertorio che comincia ad assumere una propria identit&agrave; grazie alle prime composizioni strumentali di Barrett. E&rsquo; in questo periodo che i Pink Floyd conoscono quelli che diventeranno i loro manager: Andrew King e Peter Jenner. <br /> <br /> Nella &ldquo;Swingin&rsquo; London&rdquo;, i Pink Floyd riescono a farsi notare come una delle band pi&ugrave; originali e imprevedibili, in virt&ugrave; soprattutto delle esibizioni all&rsquo;Ufo Club, un locale in cui il gruppo sperimenta i suoi primi coinvolgenti light-show, tentando di coinvolgere il pubblico con proiezione di immagini, diapositive e l&rsquo;impiego massiccio di un efficace impianto luci. <br /> <br /> A cavallo tra il &lsquo;66 e il &lsquo;67, i Pink Floyd entrano in sala d&rsquo;incisione, per i primi demo, con risultati poco incoraggianti: bisogner&agrave; attendere ancora qualche mese, infatti, per la pubblicazione del primo singolo del complesso, &ldquo;Arnold Layne/ Candy and a Currant Bun&rdquo; (prodotto da Joe Boyd). <br /> <br /> Il successo arriva immediato ed &egrave; seguito a breve distanza da un secondo singolo-hit, &ldquo;See Emily Play/ The Scarecrow&rdquo;: la band partecipa per ben tre volte consecutive a &ldquo;Top of the Pops&rdquo; ed &egrave; finalmente pronta per il primo album, pubblicato nell&rsquo;estate del &lsquo;67: The Piper at the Gates of Down. Il disco, prodotto da Norman Smith, si impone subito grazie al sound particolare e assolutamente innovativo e a testi singolari, divisi tra atmosfere oniriche e spaziali (&ldquo;Astronomy Domine&rdquo;, &ldquo;Interstellar Overdrive&rdquo;) e brevi filastrocche per le quali Barrett attinge al mondo delle fiabe (&ldquo;The Gnome&rdquo;, &ldquo;The Scarecrow&rdquo;, &ldquo;Lucifer Sam&rdquo;). <br /> <br /> &ldquo;Astronomy Domine&rdquo; &egrave; il resoconto di un viaggio stellare intrapreso da Barrett attraverso l&rsquo;uso dell&rsquo;Lsd: il basso pulsante rappresenta la connessione radio con la terra, mentre la chitarra onnipresente, insieme a un canto maestoso e solenne, sembrano errare in un panorama cosmico oscuro, con il drumming forsennato di Mason, a enfatizzare le parti pi&ugrave; drammatiche.Il capolavoro del disco, e forse anche l&rsquo;apice della produzione di Barrett, &egrave; per&ograve;: &ldquo;Interstellar Overdrive&rdquo;. E&rsquo; la cronaca di un viaggio umano nell&rsquo;universo. Introdotta da un riff da film dell&rsquo;orrore, si sviluppa nei suoi undici minuti seguendo una sola regola: almeno uno strumento deve mantenere il ritmo. E sopra questo ritmo, si sviluppa una jam session acidissima, fatta di astronavi che sfrecciano, di asteroidi che si scontrano, di alieni e alienazioni, di muri spaziali, di tempeste stellari, di quiete cosmica, di paradisi irraggiungibili. Ma Barrett &egrave; anche un maestro nel raccontare filastrocche, come &ldquo;Lucifer Sam&rdquo;, sorta di proto-hard rock, con un riff incalzante, accompagnato da tastiere che sembrano richiamare una atmosfera orientale, &ldquo;The Scarecrow&rdquo;, basata su due nacchere e su un canto allucinato, e la gag comica in stile &ldquo;freak&rdquo; di &ldquo;Bike&rdquo;. I lunghi viaggi &ldquo;acidi&rdquo; e le atmosfere scanzonate, uniti a una sonorit&agrave; articolata, nata dall&rsquo;unione di influenze diverse ma sempre del tutto unica e peculiare, permettono al disco di essere tutt&rsquo;oggi uno dei lavori universalmente pi&ugrave; amati del quartetto. In seguito a questo successo, ormai lanciati verso una folgorante carriera, i quattro partono per gli Stati Uniti in tour, ma &egrave; proprio qui che conosceranno le prime difficolt&agrave;. <br /> <br /> Barrett, infatti, comincia a manifestare i sintomi della schizofrenia (causata molto probabilmente dall&rsquo;assunzione sistematica di Lsd), assentandosi sempre di pi&ugrave; dalla vita del complesso: gli spettacoli dal vivo si fanno insostenibili, cos&igrave; come la pressione che il mondo della musica esercita su quella che &egrave; ritenuta, a ragione, la mente creativa del gruppo. <br /> <br /> La band opta allora per una soluzione di compromesso, con l&rsquo;ingaggio del chitarrista David Gilmour (gi&agrave; amico d&rsquo;infanzia di Barrett e Waters, nato a Cambridge il 6/3/1946), il quale, secondo i progetti del management, deve sopperire alle mancanze di Barrett (che comunque resta nelle vesti di autore) nei concerti. I singoli &ldquo;Apples &amp; Oranges&rdquo; e &ldquo;It Would Be So Nice&rdquo; non replicano i successi precedenti e gli atteggiamenti bizzarri e imprevedibili di Barrett cominciano a minare l&rsquo;attivit&agrave; del gruppo.Le precarie condizioni psichiche portano il leader a un impenetrabile autoisolamento e a un progressivo allontanamento dalle scene musicali, non prima della difficoltosa produzione di The Madcap Laughs (gennaio 1970) e Barrett (novembre 1970), due eccellenti album solisti realizzati con l&rsquo;aiuto di Gilmour e Wright. <br /> ', 'http://userserve-ak.last.fm/serve/252/39219129.jpg'),
(4, 'Red Hot Chili Peppers', 'me so rotto i cojoni', NULL),
(29, 'Led Zeppelin', '&lt;p&gt;I Led Zeppelin sono stati uno dei pi&amp;uacute; importanti gruppi rock britannici degli anni settanta. Sono considerati fra gli artisti di maggior successo nella storia della musica e fra gli innovatori del rock in generale. Vengono considerati i principali pionieri dell&amp;rsquo;hard rock/heavy metal insieme a Deep Purple e a Black Sabbath. La loro musica &amp;egrave; stata soprattutto una miscela di generi diversi, tra cui blues, rockabilly (spesso nei live, riproponevano canzoni rese famose da Elvis Presley e Eddie Cochran) e folk.&lt;/p&gt;\r\n&lt;p&gt;Il gruppo, formatosi nel 1968 e scioltosi nel 1980 in Inghilterra, anno della morte del batterista, fu composto per l&amp;rsquo;intero periodo della sua attivit&amp;agrave; da Jimmy Page (chitarra), Robert Plant (voce e armonica), John Paul Jones (basso e tastiere) e John Bonham (batteria).&lt;/p&gt;', 'http://userserve-ak.last.fm/serve/500/23981001/Led+Zeppelin+19700327_LA.jpg'),
(30, 'Coldplay', '&lt;p&gt;Coldplay &amp;egrave; il nome di un gruppo post-Britpop/Rock alternativo di Londra  (Regno Unito) noto per le melodie dolci e i testi introspettivi.&lt;br /&gt; &lt;br /&gt; I suoi membri sono:&lt;br /&gt; &lt;br /&gt; * Chris Martin: leader della band, voce principale,  pianoforte/tastiera e chitarra&lt;br /&gt; * Johnny Buckland: chitarra principale, armonica, cori&lt;br /&gt; * Guy Berryman: basso, sintetizzatore, armonica e cori&lt;br /&gt; * Will Champion: batterista/percussionista, piano e cori.&lt;br /&gt; &lt;br /&gt; Le prime produzioni dei Coldplay sono influenzate da artisti come  Radiohead, Jeff Buckley, e Travis. Altre ascendenze riguardano anche U2,  R.E.M., Pink Floyd, John Lennon, The Smiths, Sparklehorse, The Stone  Roses, Tom Waits, Neil Young, Echo and the Bunnymen e, pi&amp;ugrave; di recente,  Johnny Cash. Prima della sua morte, Cash era infatti pronto a registrare  un brano scritto dalla band.&lt;/p&gt;', 'http://userserve-ak.last.fm/serve/252/17666215.jpg'),
(31, 'Gorillaz', '&lt;p&gt;I Gorillaz sono una band musicale britannica atipica, poich&amp;eacute; non si  mostrano mai in pubblico e nei videoclip appaiono sotto forma di cartone  animato. Il leader e cantante del gruppo &amp;egrave; Damon Albarn, leader dei  Blur. Il gruppo musicale &amp;egrave; composto da 4 membri: 2D, Noodle, Murdoc  Niccals e Russell.&lt;br /&gt; &lt;br /&gt; Le loro canzoni sono un misto di tutti i generi ma prediligono  l&amp;rsquo;elettronica e l&amp;rsquo;Hip-Hop.&lt;br /&gt; &lt;br /&gt; Damon Albarn e Jamie Hewlett, le persone dietro ai Gorillaz, iniziarono  la carriera nel 1998 sotto il nome di &amp;ldquo;Gorilla&amp;rdquo;, pubblicando &amp;ldquo;Ghost  Train&amp;rdquo;.&lt;/p&gt;', 'http://userserve-ak.last.fm/serve/252/43356899.jpg'),
(32, 'Ludovico Einaudi', '&lt;p&gt;Ludovico Einaudi, compositore e pianista.&lt;br /&gt; La sua musica affonda le radici nella tradizione classica con l&amp;rsquo;innesto  di elementi derivati&amp;nbsp;dalla musica&amp;nbsp;pop, rock, folk e contemporanea.&amp;nbsp;&lt;br /&gt; Le sue melodie, profondamente evocative e di grande impatto emotivo,&amp;nbsp;lo  hanno reso oggi uno degli artisti pi&amp;ugrave; apprezzati e richiesti della&amp;nbsp;scena  europea.&lt;br /&gt; A seguito del suo ultimo album, Divenire (Decca 2006,&amp;nbsp;Disco d&amp;rsquo;Oro in  Italia), ha fatto un tour europeo di oltre 80 tappe,&amp;nbsp;culminato nel  novembre del 2007 con un concerto alla Royal Albert Hall di Londra  davanti a 4000 persone.&lt;br /&gt; Nel 2008 ha tenuto concerti e promosso la sua musica anche negli Stati  Uniti, Giappone e in India.&lt;br /&gt; All&amp;rsquo;inizio del 2009 si &amp;egrave; dedicato alla stesura e alla registrazione del  nuovo album, Nightbook.&lt;br /&gt; &amp;nbsp;&lt;br /&gt; Nato a Torino il 23 novembre 1955, si &amp;egrave; diplomato in composizione al  Conservatorio G.&amp;nbsp;Verdi di Milano, e si &amp;egrave; perfezionato sotto la guida di  Luciano&amp;nbsp;Berio.&lt;br /&gt; Verso la fine degli anni Ottanta attraversa un periodo di  sperimentazione e ricerca, durante il quale inizia a collaborare con il  teatro e la danza.&lt;/p&gt;', 'http://userserve-ak.last.fm/serve/252/36082491.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_contenuti`
--

DROP TABLE IF EXISTS `mio_contenuti`;
CREATE TABLE IF NOT EXISTS `mio_contenuti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(100) NOT NULL,
  `alias_titolo` varchar(100) NOT NULL,
  `intro_testo` mediumtext NOT NULL,
  `altro_testo` mediumtext NOT NULL,
  `pubblicato` tinyint(1) unsigned NOT NULL,
  `idcategoria` int(11) unsigned NOT NULL,
  `creato_il` datetime NOT NULL,
  `idautore` int(11) unsigned NOT NULL,
  `modificato_il` datetime NOT NULL,
  `mod_autore` int(11) unsigned NOT NULL,
  `chiavi_meta` text NOT NULL,
  `descr_meta` text NOT NULL,
  `accesso` int(11) unsigned NOT NULL,
  `visite` int(11) unsigned NOT NULL,
  `voto` float unsigned NOT NULL,
  `inModifica` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `mio_contenuti`
--

INSERT INTO `mio_contenuti` (`id`, `titolo`, `alias_titolo`, `intro_testo`, `altro_testo`, `pubblicato`, `idcategoria`, `creato_il`, `idautore`, `modificato_il`, `mod_autore`, `chiavi_meta`, `descr_meta`, `accesso`, `visite`, `voto`, `inModifica`) VALUES
(1, 'intro', 'intro-alias', '<p>contenuto pappappero</p>\r\n<p>pippo pippo</p>', '', 1, 1, '2007-11-19 19:26:11', 1, '0000-00-00 00:00:00', 0, 'asd', 'asd', 1, 0, 1, 0),
(2, 'Titolo2', 'titolo-2', '<p>intro-testo</p>', '', 1, 0, '2010-05-27 14:03:09', 1, '2010-05-27 14:03:13', 0, 'dqad', 'qqwwd', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_gruppi`
--

DROP TABLE IF EXISTS `mio_gruppi`;
CREATE TABLE IF NOT EXISTS `mio_gruppi` (
  `id` tinyint(3) NOT NULL DEFAULT '0',
  `nome` varchar(50) NOT NULL,
  `idTipo` tinyint(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `mio_gruppi`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `mio_menu`
--

DROP TABLE IF EXISTS `mio_menu`;
CREATE TABLE IF NOT EXISTS `mio_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipomenu` varchar(25) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `link` text NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `pubblicato` tinyint(1) unsigned NOT NULL,
  `padre` int(11) unsigned NOT NULL,
  `idcomponente` int(11) unsigned NOT NULL,
  `ordine` int(11) NOT NULL,
  `accesso` tinyint(3) unsigned NOT NULL,
  `parametri` text,
  `inModifica` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `mio_menu`
--

INSERT INTO `mio_menu` (`id`, `tipomenu`, `nome`, `link`, `tipo`, `pubblicato`, `padre`, `idcomponente`, `ordine`, `accesso`, `parametri`, `inModifica`) VALUES
(1, 'componente', 'nome', 'index.php', 'componente', 1, 0, 1, 1, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_mio`
--

DROP TABLE IF EXISTS `mio_mio`;
CREATE TABLE IF NOT EXISTS `mio_mio` (
  `idmio` int(2) NOT NULL AUTO_INCREMENT,
  `mio` varchar(20) NOT NULL,
  KEY `idmio` (`idmio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `mio_mio`
--

INSERT INTO `mio_mio` (`idmio`, `mio`) VALUES
(1, 'asd'),
(2, 'ads');

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_moduli`
--

DROP TABLE IF EXISTS `mio_moduli`;
CREATE TABLE IF NOT EXISTS `mio_moduli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenuto` text,
  `titolo` text NOT NULL,
  `ordine` int(11) NOT NULL,
  `posizione` text NOT NULL,
  `pubblicato` tinyint(1) NOT NULL,
  `nome_modulo` varchar(50) NOT NULL,
  `accesso` tinyint(3) NOT NULL,
  `mostra_titolo` tinyint(1) NOT NULL,
  `parametri` text NOT NULL,
  `inModifica` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `mio_moduli`
--

INSERT INTO `mio_moduli` (`id`, `contenuto`, `titolo`, `ordine`, `posizione`, `pubblicato`, `nome_modulo`, `accesso`, `mostra_titolo`, `parametri`, `inModifica`) VALUES
(1, NULL, 'Menu Principale', 1, 'left', 1, 'mod_modulo', 0, 1, 'moduleclass_sfx=suffissoClassCss\r\ncache=0\r\nfirebots=1\r\nrssurl=\r\nrsstitle=1\r\nrssdesc=1\r\nrssimage=1\r\nrssitems=3\r\nrssitemdesc=1\r\nword_count=0\r\nfalso=false\r\nrsscache=3600', 0),
(2, '<p>Fare il login con un utente amministratore per modificare/aggiungere artisti</p>\r\n<p>Gli utenti registrati possono fare... boh, al momento nulla. Forse vincere un premio</p>', 'secondoModulo', 3, 'left', 1, 'nome', 0, 0, '', 0),
(3, NULL, 'debug', 1, 'footer', 1, 'mod_debug', 0, 1, '', 0),
(4, NULL, 'Login Form', 4, 'left', 1, 'mod_login', 0, 1, '', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_tags`
--

DROP TABLE IF EXISTS `mio_tags`;
CREATE TABLE IF NOT EXISTS `mio_tags` (
  `idTag` int(36) unsigned NOT NULL AUTO_INCREMENT,
  `nomeTag` varchar(15) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `mio_tags`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `mio_tipi_utenti`
--

DROP TABLE IF EXISTS `mio_tipi_utenti`;
CREATE TABLE IF NOT EXISTS `mio_tipi_utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `mio_tipi_utenti`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `mio_tracce`
--

DROP TABLE IF EXISTS `mio_tracce`;
CREATE TABLE IF NOT EXISTS `mio_tracce` (
  `idTraccia` int(36) unsigned NOT NULL AUTO_INCREMENT,
  `nomeTraccia` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `durata` time NOT NULL DEFAULT '00:00:00',
  `idAlbum` int(36) unsigned NOT NULL,
  `ordine` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idTraccia`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=32 ;

--
-- Dump dei dati per la tabella `mio_tracce`
--

INSERT INTO `mio_tracce` (`idTraccia`, `nomeTraccia`, `durata`, `idAlbum`, `ordine`) VALUES
(1, 'Shine On You Crazy Diamond', '00:13:27', 1, 1),
(2, 'Welcome to the machine', '00:07:25', 1, 2),
(3, 'Have a Cigar', '00:05:06', 1, 3),
(4, 'Wish You Were here', '00:05:39', 1, 4),
(5, 'Shine On You Crazy Diamond', '00:12:20', 1, 5),
(6, 'La Terra Dei Cachi', '00:04:18', 8, 1),
(7, 'Burattino senza fichi', '00:04:50', 8, 2),
(8, 'T.V.U.M.D.B.', '00:04:45', 8, 3),
(9, 'Lo stato A, lo stato B', '00:04:30', 8, 4),
(10, 'El Pube', '00:05:02', 8, 5),
(11, 'Omosessualita''', '00:03:00', 8, 6),
(12, 'Mio cuggino', '00:06:06', 8, 7),
(13, 'First me, second me', '00:03:32', 8, 8),
(14, 'Milza', '00:04:33', 8, 9),
(15, 'Li immortacci', '00:04:39', 8, 10),
(16, 'Tapparella', '00:06:08', 8, 11),
(17, 'Neanche un minuto di non caco', '00:01:43', 8, 12),
(18, '(A) Speak To Me (B) Breathe In The Air', '00:03:57', 2, 1),
(19, 'On the Run', '00:03:46', 2, 2),
(20, 'The Great Gig in the Sky', '00:05:49', 2, 3),
(21, 'Time', '00:06:46', 2, 4),
(22, 'Money', '00:06:29', 2, 5),
(23, 'Us and Them', '00:06:56', 2, 6),
(24, 'Any Colour You Like', '00:03:19', 2, 7),
(25, 'Eclipse', '00:02:00', 2, 8),
(26, 'Brain Damage', '00:03:49', 2, 9),
(27, 'Pigs On The Wing (Part One)', '00:01:25', 3, 1),
(28, 'Dogs', '00:17:04', 3, 2),
(29, 'Pigs (Three Different Ones)', '00:11:25', 3, 3),
(30, 'Sheep', '00:10:17', 3, 4),
(31, 'Pigs On The Wing (Part Two)', '00:01:25', 3, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_utenti`
--

DROP TABLE IF EXISTS `mio_utenti`;
CREATE TABLE IF NOT EXISTS `mio_utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `abilitato` tinyint(4) NOT NULL DEFAULT '1',
  `idGruppo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dataRegistrazione` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `mio_utenti`
--

INSERT INTO `mio_utenti` (`id`, `username`, `password`, `nome`, `email`, `abilitato`, `idGruppo`, `dataRegistrazione`) VALUES
(1, 'frosso', 'frosso', 'frosso', 'frosso', 1, 2, '2010-05-28 14:42:47'),
(8, 'lory', 'lory', 'lory', 'lory@losemenz.it', 1, 1, '2010-06-08 13:06:46'),
(9, 'alby', 'alby', 'alby', 'alby@alby.it', 1, 1, '2010-06-08 14:06:22'),
(10, 'ilpene', 'ilmerda', 'ilpene', 'coltello@dispose.it', 1, 1, '2010-06-10 10:57:20');

-- --------------------------------------------------------

--
-- Struttura della tabella `mio_voci`
--

DROP TABLE IF EXISTS `mio_voci`;
CREATE TABLE IF NOT EXISTS `mio_voci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_app` varchar(11) NOT NULL,
  `nome` varchar(11) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `ordine` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `mio_voci`
--

INSERT INTO `mio_voci` (`id`, `menu_app`, `nome`, `parent`, `ordine`) VALUES
(1, 'main', 'voce1', 0, 1),
(2, 'main', 'voce2', 0, 2),
(3, 'main', 'voce2-sotto', 2, 1),
(4, 'main', 'voce2-sotto', 2, 2);
