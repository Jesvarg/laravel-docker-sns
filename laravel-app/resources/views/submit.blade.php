<form method="POST" action="/submit">
    @csrf
    <label>Name:</label>
    <input type="text" name="name"><br>

    <label>Email:</label>
    <input type="email" name="email"><br>

    <label>Message:</label>
    <textarea name="message"></textarea><br>

    <input type="submit" value="Submit">
</form>
