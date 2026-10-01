## Documentation

KPI Widgets adds single-number widgets to the Matomo dashboard. Each widget shows the value of the selected period and an evolution badge against the previous period. Widgets follow the site, period, date and segment of the dashboard.

Add them from the "Dashboard" menu, in the KPI category. Widgets are grouped under four subcategories.

### Traffic
- Visits, unique visitors, users
- New visits
- Returning visitors, unique returning visitors, returning users
- Actions, page views, unique page views
- AI agent visits and human visits (requires the AIAgents plugin)

### Acquisition
- Visits from search engines, AI assistants, direct entry, websites, social networks and campaigns
- Share of visits for each of these channels
- The AI assistants widgets appear when your Matomo version tracks AI assistants as a referrer type

### Behavior
- Bounce rate, actions per visit, max actions in one visit
- Average time on site
- Average page load time (requires the PagePerformance plugin)
- Downloads, unique downloads, outlinks, unique outlinks
- Internal searches, search keywords

### Goals
- Conversions, conversion rate and revenue, for all goals and for each goal of the site
- Visits with conversions

Widgets whose source plugin or metric is not available are not listed. Values come from the Matomo API (`API.get` and `Goals.get`), shared by every widget of the dashboard and cached for 5 minutes on running periods, 1 hour on closed periods.
