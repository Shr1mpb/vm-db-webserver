import http.client

conn = http.client.HTTPConnection("127.0.0.1", 25565, timeout=5)
try:
    conn.request("GET", "/")
    response = conn.getresponse()
    print(f"状态码: {response.status} {response.reason}")
    print(response.read().decode('utf-8'))
finally:
    conn.close()