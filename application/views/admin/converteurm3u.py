import csv
import tkinter as tk
from tkinter import filedialog, messagebox



fixed_values = {
    "Nom banner": "https://amiratv-atlas.000webhostapp.com/dooo/assets/images/Dooo_poster_placeholder.png",
    "Type de Flux": "m3u8",
    "content_type": "3",
    "type": "0",
    "Statut": "1",
    "featured": "1",
    "user_agent": "",
    "referer": "",
    "cookie": "",
    "headers": "[]",
    "drm_uuid": "WIDEVINE",
    "drm_license_uri": "",
    "genres": "bein sport"
}
def convert_m3u_to_csv(m3u_file, csv_file):
    with open(m3u_file, 'r') as m3u_file:
        lines = m3u_file.readlines()

    with open(csv_file, 'w', newline='') as csv_file:
        writer = csv.writer(csv_file)
        writer.writerow(["id","Nom", "banner", "Type de Flux", "URL", "content_type", "type", "Statut", "featured", "user_agent", "referer", "cookie", "headers", "drm_uuid", "drm_license_uri", "genres"])
        
        name = None
        for line in lines:
            line = line.strip()
            if line.startswith('#EXTINF:'):
                # Extracting the name from the line
                name = line.split(',')[-1]
            elif line and not line.startswith('#'):
                # If the line is not empty and doesn't start with '#', it's a URL
                if name:
                    # Assume you want to fix values for each field
                    row = ["",name,"https://amiratv-atlas.000webhostapp.com/dooo/assets/images/Dooo_poster_placeholder.png", "M3u8", line, "3", "0", "1", "1", "", "", "", "[]", "WIDEVINE", "", "	bein sport"]
                    writer.writerow(row)
                    name = None

def browse_file():
    filename = filedialog.askopenfilename()
    entry_source.delete(0, tk.END)
    entry_source.insert(0, filename)
    preview_csv_file()

def browse_save_file():
    filename = filedialog.asksaveasfilename(defaultextension=".csv")
    entry_destination.delete(0, tk.END)
    entry_destination.insert(0, filename)

def convert():
    source_file = entry_source.get()
    destination_file = entry_destination.get()
    convert_m3u_to_csv(source_file, destination_file)
    messagebox.showinfo("Conversion terminée", "Conversion terminée avec succès.")
    preview_csv_file(destination_file)

def preview_csv_file(csv_file):
    try:
        with open(csv_file, 'r') as file:
            preview_text.delete(1.0, tk.END)
            preview_text.insert(tk.END, file.read())
    except FileNotFoundError:
        messagebox.showerror("Erreur", "Fichier introuvable.")

# Création de la fenêtre principale
window = tk.Tk()
window.title("Convertisseur m3u vers CSV")

# Création des widgets
label_source = tk.Label(window, text="Fichier source:")
label_source.grid(row=0, column=0, padx=5, pady=5)

entry_source = tk.Entry(window, width=50)
entry_source.grid(row=0, column=1, padx=5, pady=5)

button_browse = tk.Button(window, text="Parcourir", command=browse_file)
button_browse.grid(row=0, column=2, padx=5, pady=5)

label_destination = tk.Label(window, text="Enregistrer sous:")
label_destination.grid(row=1, column=0, padx=5, pady=5)

entry_destination = tk.Entry(window, width=50)
entry_destination.grid(row=1, column=1, padx=5, pady=5)

button_browse_save = tk.Button(window, text="Parcourir", command=browse_save_file)
button_browse_save.grid(row=1, column=2, padx=5, pady=5)

button_convert = tk.Button(window, text="Convertir", command=convert)
button_convert.grid(row=2, column=1, padx=5, pady=5)

preview_text = tk.Text(window, height=20, width=70)
preview_text.grid(row=3, column=0, columnspan=3, padx=5, pady=5)

# Lancement de la boucle principale
window.mainloop()
