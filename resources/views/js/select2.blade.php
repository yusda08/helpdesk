<script>
    function format(repo) {
        if (repo.loading) {
            return repo.text;
        }
        let $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository_title'></div>
            </div>`
        );
        $container.find(".select2-result-repository_title").text(repo.text);
        return $container;
    }
    function formatSelection(repo) {
        return repo.text;
    }
</script>
