DROP DATABASE IF EXISTS ReseauDB;
CREATE DATABASE IF NOT EXISTS ReseauDB;

Use ReseauDB;

CREATE TABLE Personnes(
    PersonneId char(16) PRIMARY KEY,
    Email varchar(255) NOT NULL,
    Nom varchar(100) NOT NULL,
    Prenom varchar(100) NOT NULL,
    Pseudo varchar(256),
    HashMDP varchar(255) NOT NULL,
    AvatarPath varchar(255),
    EstProfesseur BOOLEAN
    );
    
CREATE TABLE Amis(
    Ami1 char(16) NOT NULL,
    Ami2 char(16) NOT NULL,
    FOREIGN KEY(Ami1) REFERENCES Personnes(PersonneId),
    FOREIGN KEY(Ami2) REFERENCES Personnes(PersonneId),
    PRIMARY KEY(Ami1,Ami2)
    );
    
CREATE TABLE Groupes(
    GroupeId char(16) PRIMARY KEY,
    Annee Date,
    Matiere varchar(50),
    Administrateur char(16),
    FOREIGN KEY(Administrateur) REFERENCES Personnes(PersonneId)
    );
    
CREATE TABLE AppartientPersonneGroupe(
    Personne char(16) NOT NULL,
    Groupe char(16) NOT NULL,
    FOREIGN KEY(Personne) REFERENCES Personnes(PersonneId),
    FOREIGN KEY(Groupe) REFERENCES Groupes(GroupeId),
    PRIMARY KEY (Personne,Groupe)
    );
    
CREATE TABLE Posts(
    PostId char(16) PRIMARY KEY,
    Titre varchar(40) NOT NULL,
    Contenu Text NOT NULL,
    DatePoste Date NOT NULL,
    Likes integer,
    CouverturePath varchar(255),
    Auteur char(16) NOT NULL,
    Groupe char(16),
    FOREIGN KEY(Auteur) REFERENCES Personnes(PersonneId),
    FOREIGN KEY(Groupe) REFERENCES Groupes(GroupeId)
    );
    
CREATE TABLE Commentaires(
    CommentId char(16) PRIMARY KEY,
    Contenu Text NOT NULL,
    DateCommentaire Date NOT NULL,
    Likes integer,
    ParentPost char(16) NOT NULL,
    Auteur char(16) NOT NULL,
    FOREIGN KEY(ParentPost) REFERENCES Posts(PostId),
    FOREIGN KEY(Auteur) REFERENCES Personnes(PersonneId)
    );