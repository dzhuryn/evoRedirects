<h1>
    <i class="fa fa-users"></i>Evo Redirects
</h1>

<div id="actions">
    <ul class="actionButtons">
        <li id="Button4"><a class="add-redirect" href="#">Добавить редирект</a></li>
        <li id="Button5"><a onclick="document.location.href='index.php?a=106';" href="#">Закрыть</a></li>
    </ul>
</div>
<div class="tab-page">


        <div id="container"></div>
        <div id="pager"></div>

</div>

<script>

    var dataTable = webix.ui({
        view: "datatable",
        container: "container",
        url: "[+moduleurl+]action=load",
        save: "[+moduleurl+]action=save",
        editable: true,
        autoheight: true,
        id: "table",

        pager: {
            container: "pager", // the container to place the pager controls into
            size: 500, // the number of records per a page
            group: 15   // the number of pages in the pager
        },

        columns: [
            {id: "id", header: "", fillspace: 1},
            {id: "old_url", editor: "text", header: "Старый Url", fillspace: 6},
            {id: "doc_id", editor: "text", header: "docId", fillspace: 1},
            {id: "new_url", editor: "text", header: "Новый url", fillspace: 6},
            {
                id: "remove",
                header: "x",
                template: "<span data-id=#id# class='webix_icon fa-remove remove-row'></span>",
                fillspace: 1
            },
        ]
    });

    webix.dp($$("table")).attachEvent('onAfterSaveError', function (id, status, response, details) {
        webix.alert("Произошла ошибка");
    });
    webix.dp($$("table")).attachEvent("onAfterSave", function (response, id, object) {

        if (response === null || response.status !== 'success') {
            webix.alert("Произошла ошибка");

        }
    });

    $(document)
        .on('click', '.add-redirect', function (e) {
            e.preventDefault();
            dataTable.add({})
        })
        .on('click', '.remove-row', function () {
            dataTable.remove($(this).data('id'))
        })
</script>
