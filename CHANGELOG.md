## Changelog

### v5.1.0

- Add goal-specific widgets (Conversions, Conversion Rate, Revenue per goal)
- Add evolution indicator with period comparison (colored pill: green/red/grey)
- Add subcategories for better widget organization (Traffic, Engagement, Goals)
- New MetricsService with in-memory API cache (-90% API calls)
- Single API call shared across all widgets
- Optional evolution calculation (can be disabled globally or per widget)
- Major refactoring with abstract Base class
- Remove code duplication between Controller and Widgets
- Add strict types declarations
- Use PHP 8 match expressions
- Centralized metrics logic in Services/MetricsService.php
- New widget design with evolution pill below value
- Pastel background colors for evolution indicator
- Dark mode support

### v5.0.4

- update: marketplace category and cover

### v5.0.3

- update: Documentation

### v5.0.2

- update: Format numbers metrics

### v5.0.1

- update: plugin.json

### v5.0.0

- Compatibility with Matomo 5.x
- Starting using semver for versioning

### v1.1.6

- update: Format time string to real time

### v1.1.5

- update: Remove non-used dependecies

### v1.1.4

- Fix : stdClass::$avg_time_generation error

### v1.1.3

- Add '-' when no data to display
- Set min height to widget body

### v1.1.2

- fix: Widget height

### v1.1.1

- update: Add common structure to widget

### v1.1.0

- Support for Matomo 4.x
- Fix 1 translation

### v1.0.4

- update plugin.json informations

### v1.0.3

- fix: remove old files

### v1.0.2

- update: CSS class name

### v1.0.1

- Fixing issue from root folder name

### v1.0.0

- Create many widgets
- Add translation to french (fr)
