<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029235646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food ADD tags INT DEFAULT NULL, ADD ingredients INT DEFAULT NULL');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F76FBC9426 FOREIGN KEY (tags) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F74B60114F FOREIGN KEY (ingredients) REFERENCES ingredients (id)');
        $this->addSql('CREATE INDEX IDX_D43829F76FBC9426 ON food (tags)');
        $this->addSql('CREATE INDEX IDX_D43829F74B60114F ON food (ingredients)');
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114FD43829F7');
        $this->addSql('DROP INDEX IDX_4B60114FD43829F7 ON ingredients');
        $this->addSql('ALTER TABLE ingredients DROP food');
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC9426D43829F7');
        $this->addSql('DROP INDEX IDX_6FBC9426D43829F7 ON tags');
        $this->addSql('ALTER TABLE tags DROP food');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients ADD food INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114FD43829F7 FOREIGN KEY (food) REFERENCES food (id)');
        $this->addSql('CREATE INDEX IDX_4B60114FD43829F7 ON ingredients (food)');
        $this->addSql('ALTER TABLE tags ADD food INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC9426D43829F7 FOREIGN KEY (food) REFERENCES food (id)');
        $this->addSql('CREATE INDEX IDX_6FBC9426D43829F7 ON tags (food)');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F76FBC9426');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F74B60114F');
        $this->addSql('DROP INDEX IDX_D43829F76FBC9426 ON food');
        $this->addSql('DROP INDEX IDX_D43829F74B60114F ON food');
        $this->addSql('ALTER TABLE food DROP tags, DROP ingredients');
    }
}
