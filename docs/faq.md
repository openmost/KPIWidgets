## FAQ

**How do I add a KPI widget to a dashboard?**

Open a dashboard, open the "Dashboard" menu, choose the KPI category, then a subcategory (Traffic, Acquisition, Behavior or Goals) and click the widget.

**Why can't I find a widget, such as AI agent visits or page load time?**

Widgets are hidden when their source is missing: AI agent and human visits need the AIAgents plugin, average page load time needs the PagePerformance plugin, and the AI assistants widgets need a Matomo version that tracks AI assistants as a referrer type.

**How is the evolution calculated?**

The value of the selected period is compared with the previous period of the same length. For metrics where lower is better, such as the bounce rate, a decrease is shown as positive.

**Do the widgets follow segments?**

Yes, the segment selected on the dashboard applies to every KPI widget.

**Why does a value take a few minutes to update?**

Values are cached for 5 minutes on periods still running and for 1 hour on closed periods, so dashboards with many widgets stay fast.

**Is the plugin available to all users?**

Yes. Any user who can view a site can add KPI widgets for it.

**Which versions of Matomo are supported?**

Version 5.3 and later need Matomo 5.13.0 or later. Use the 6.x versions for Matomo 6.
