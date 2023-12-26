export default {
    props: ['link'],
    emits: ['confirm'],
    template:
        `
          <div id="div-dialog-template">
          <h2>提示</h2>
          <p>若页面无法复制请手动复制</p>
          <textarea id="div-dialog-textarea" disabled>{{link}}</textarea>
          <div id="div-dialog-buttons">
            <button @click="copy" class="button-style" style="background-color: cornflowerblue">复制</button>
            <button @click="$emit('confirm')" class="button-style" style="background-color: hotpink">确定</button>
          </div>
          </div>
        `
    ,
    methods: {
        copy() {
            let textarea = document.getElementById("div-dialog-textarea");
            textarea.select()
            document.execCommand("copy", true, null)
            alert("复制成功")
        }
    }
}