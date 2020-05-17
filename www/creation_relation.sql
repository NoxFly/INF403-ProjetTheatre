CREATE TABLE LesZones
(
    numZ INT CHECK (numZ > 0),
    nomC VARCHAR(50),
    CONSTRAINT priZ PRIMARY KEY (numZ)
);

CREATE TABLE LesCategories
(
    nomC VARCHAR(50) CHECK (nomC="orchestre" OR nomC="balcon" OR nomC="poulailler" OR nomC="1er balcon" OR nomC="2nd balcon"),
    prix DECIMAL NOT NULL CHECK (prix > 0),
    CONSTRAINT priC PRIMARY KEY (nomC)
);

CREATE TABLE LesPlaces
(
    noPlace INT CHECK (noPlace > 0),
    noRang INT CHECK (noRang > 0),
    noZone INT,
    CONSTRAINT priP PRIMARY KEY (noPlace,noRang)
);

CREATE TABLE LesSpectacles
(
    numS INT CHECK (numS > 0),
    nomS VARCHAR(50),
    duree INT (duree > 0),
    CONSTRAINT priS PRIMARY KEY (numS)
);

CREATE TABLE LesRepresentations
(
    dateRep DATE,
    numS INT CHECK (numS > 0),
    CONSTRAINT priR PRIMARY KEY (dateRep)
);

CREATE TABLE LesTickets
(
    noSerie INT,
    numS INT CHECK (numS > 0),
    dateRep DATE,
    noPlace INT CHECK (noPlace > 0),
    noRang INT CHECK (noRang > 0),
    dateEmission DATE,
    noDossier INT CHECK (noDossier > 0),
    CONSTRAINT priT PRIMARY KEY (noSerie, numS, dateRep, noPlace, noRang)
);

CREATE TABLE LesDossiers
(
    noDossier INT CHECK (noDossier > 0),
    montant INT CHECK (montant > 0),
    CONSTRAINT priD PRIMARY key (noDossier)
);