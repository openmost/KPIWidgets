# KPI Widgets

Single-number KPI widgets for your Matomo dashboards, each with its evolution against the previous period.

## Features

- **One widget per KPI**: the value of the selected period, formatted like Matomo (numbers, percentages, durations, money), with an evolution badge comparing it with the previous period. For metrics where lower is better, such as the bounce rate, a decrease is shown as positive.
- **Follows the dashboard context**: site, period, date and the selected segment.
- **Available widgets**, grouped under the KPI category of the widget picker:
  - **Traffic**: Visits, Unique visitors, Users, Page views, Unique page views, Returning users, Returning visitors, Unique returning visitors, New visits, Actions, AI agent visits and Human visits (both need the AIAgents plugin).
  - **Acquisition**: Visits from search engines, AI assistants, direct entry, websites, social networks and campaigns, each with a matching "Share of visits" widget. The AI assistants widgets appear when your Matomo version tracks AI assistants as a referrer type.
  - **Behavior**: Bounce rate, Actions per visit, Average time on site, Max actions in one visit, Downloads, Unique downloads, Outlinks, Unique outlinks, Internal searches, Search keywords and Average page load time (needs the PagePerformance plugin).
  - **Goals**: Conversions, Conversion rate, Revenue and Visits with conversions for all goals, plus Conversions, Conversion rate and Revenue widgets for each goal of the site.
- **Hidden when unavailable**: widgets whose source plugin or metric is missing on your Matomo are not listed.
- **Fast dashboards**: all widgets of a dashboard share the same API calls, and values are cached through the Matomo cache (5 minutes for running periods, 1 hour for closed ones). Access is checked on every request, cached values included.
- Light and dark themes, translated into 12 languages.

## Requirements

- Matomo 5.13.0 or later, below 6.0.0
- Optional: AIAgents for the AI agent and human visits widgets, PagePerformance for the page load time widget, Goals for the goal widgets

## Installation / Configuration

1. Install KPI Widgets from the Marketplace (Administration > Platform > Marketplace) and activate it.
2. Open a dashboard, open the "Dashboard" menu and pick widgets from the KPI category (Traffic, Acquisition, Behavior, Goals).

There are no settings. The plugin is available to every user who can view the site.

## Privacy and data

Widgets read the reports already archived in your Matomo. The plugin sends no data to third parties.

## Need help with Matomo?

Openmost is an official Matomo Implementation Partner. We also build [custom Matomo dashboards and KPI reports](https://openmost.com/matomo/services/dashboard-build?utm_source=matomo_marketplace&utm_medium=referral&utm_campaign=services&utm_content=kpiwidgets) for executives, marketing teams and clients, with KPIs defined with you and maintained over time.

## Support

- Email: ronan@openmost.com
- Homepage: https://openmost.com/matomo/extensions/kpiwidgets
- Issues: https://github.com/openmost/KPIWidgets/issues

## Screenshots

Screenshots of the widget picker and of KPI dashboards are available in the `screenshots` folder and on the Marketplace.

## License

GPL v3 or later
