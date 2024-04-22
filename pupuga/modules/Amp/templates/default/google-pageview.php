<amp-analytics type="googleanalytics">
    <script type="application/json">
        {
            "vars": {
                "account": "<?php echo $params ?>"
            },
            "triggers": {
                "trackPageview": {
                    "on": "visible",
                    "request": "pageview"
                }
            }
        }
    </script>
</amp-analytics>