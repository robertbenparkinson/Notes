# Drupal 8 Migrate Nested Taxonomy Example

The following code will import a nested taxonomy vocabulary from a CSV file.

## Modules
    composer require drupal/migrate_plus
    composer require drupal/migrate_tools
    composer require drupal/migrate_source_csv

## Drush 
    drush en migrate
    drush en migrate_plus
    drush en migrate_tools
    drush en migrate_source_csv

## Custom Module File Structure

    test_taxonomy
        - /assets
            - /csv
                - /test_taxonomy.csv
        - /migrations
            - /test_taxonomy_migration.yml
        -/text_taxonomy.info.yml

## test_taxonomy.csv
id |name |p_id
---|-----|----
1|earth|0
2|vulcan|0
3|gorn_mother_world|0
4|star_fleet|1
5|science_academy|2
6|royal_palace|3
7|kirks_house|4
8|spocks_house|5
9|mamma_gorns_house|6
10|gorn_land|6

## test_taxonomy_migration.yml

```yml
id: test_taxonomy_migration
label: 'Test Taxonomy Migration'
migration_groups:
  - test_migration import

source:
  plugin: csv
  path: 'modules/custom/test_taxonomy/assets/csv/test_taxonomy.csv'
  delimiter: ','
  enclosure: '"'
  header_row_count: 1
  ids: [id]

  column_names:
    0:
      id: "unique id"
    1:
      name: "Name of Taxonomy Term"
    2:
      p_id: "Parent ID"

process:
##  tid: id  // if you cut this out Drupal will set tid
  name: name
  parent_id:
    -
      plugin: skip_on_empty
      method: process
      source: p_id
    -
      plugin: migration_lookup
      migration: test_taxonomy_migration
  parent:
    plugin: default_value
    default_value: 0
    source: '@parent_id'

destination:
  plugin: entity:taxonomy_term
  default_bundle: test_tags

```

## Drush Migration Command
    drush ms
    drush migrate:import test_taxonomy_migration
    drush migrate:import test_taxonomy_migration --limit=10



## Conclusion

    It Works!!! 