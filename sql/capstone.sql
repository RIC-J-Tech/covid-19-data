USE cap28_covid;


CREATE TABLE profile(
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAvatarUrl VARCHAR(256) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profilePhone VARCHAR(32),
	profileUsername VARCHAR(32) NOT NULL,
	UNIQUE(profilePhone),
	UNIQUE(profileEmail),
	UNIQUE(profileUsername),
	INDEX(profileEmail),
	PRIMARY KEY(profileId)
);


CREATE TABLE business(
   businessId BINARY(16) NOT NULL,
   businessYelpId VARCHAR(32) NOT NULL,
   businessLng DECIMAL(9,6),
   businessLat DECIMAL(9,6),
   businessName VARCHAR(128) NOT NULL,
   businessUrl VARCHAR(256) NOT NULL,
   INDEX(businessName),
   PRIMARY KEY(businessId)
);


CREATE TABLE behavior(
   behaviorId BINARY(16) NOT NULL,
	behaviorBusinessId BINARY(16) NOT NULL,
   behaviorProfileId BINARY(16) NOT NULL,
	behaviorContent VARCHAR(256) NOT NULL,
	behaviorDate DATETIME(6) NOT NULL,
	INDEX(behaviorBusinessId),
	INDEX(behaviorProfileId),
	FOREIGN KEY(behaviorBusinessId) REFERENCES business(businessId),
	FOREIGN KEY(behaviorProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(behaviorId)
);


CREATE TABLE vote(
	voteBehaviorId BINARY(16) NOT NULL,
	voteProfileId BINARY(16) NOT NULL,
	voteDate DATETIME(6) NOT NULL,
	voteResult BOOLEAN NOT NULL,
	INDEX(voteProfileId),
	INDEX(voteBehaviorId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(voteBehaviorId) REFERENCES behavior(behaviorId)
);

CREATE TABLE report(
   reportId BINARY(16) NOT NULL,
   reportBusinessId BINARY(16) NOT NULL,
   reportProfileId BINARY(16) NOT NULL,
	reportContent TEXT NOT NULL,
	reportDate DATETIME(6) NOT NULL,
	INDEX(reportBusinessId),
	INDEX(reportProfileId),
	FOREIGN KEY(reportBusinessId) REFERENCES business(businessId),
	FOREIGN KEY(reportProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(reportId)
);